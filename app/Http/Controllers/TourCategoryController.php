<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

use DB;
use App\Library\Fn;

use App\Library\Form;
use Illuminate\Support\Facades\Storage;
use App\Models\TourCategory;

class TourCategoryController extends Controller
{
  protected $table = 'tour_category';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $ops = array(
          'sort' => isset($request->sort)? $request->sort: 'updated_at',
          'dir' => isset($request->dir)? $request->dir: 'desc',

          'limit' => isset($request->limit)? $request->limit: 10,
          'page' => isset($request->page)? $request->page: 1,

          'ts' => time(),
      );


      $sth = DB::table($this->table);
      $sth->where( 'cid', '=', Session::get('cid') );


      if( isset($request->q) ){
          $ops['q'] = trim($request->q);

          $sth->where( 'name', 'LIKE', "%{$ops['q']}%" );
      }

      if( isset($request->status) ){
          $ops['status'] = trim($request->status);
          $sth->where( 'status', '=', $ops['status'] );
      }


      $total = $sth;

      $sth->orderby( $ops['sort'], $ops['dir'] );
      $sth->skip( ($ops['page']*$ops['limit'])- $ops['limit']);
      $sth->take( $ops['limit'] );


      $results = $sth->get();
      $arr['total'] = $total->count();

      $arr['data'] = $results;
      $arr['options'] = $ops;

      $arr['items'] = $this->ui->req('TourCategory')->init($arr['data'], $arr['options']);

      return response()->json($arr, 200);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('forms.tours.category.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      // dd($request);
      $validator = Validator::make($request->all(), [
          'name' => 'required|max:75',
          'end_date' => 'required',
          'start_date' => 'required',
          'permalink' => 'required',
          'image' => 'required | mimes:jpeg,jpg,png | max:1000',
      ],[
          'name.required' => 'กรุณากรอกชื่อเส้นทาง',
          'image.required' => 'กรุณาใส่รูปภาพ',
          'image.max' => 'ขนาดไฟล์เกินกำหนด',
          'image.mimes' => 'ชนิดของไฟล์ต้องเป็น jpeg,jpg,png เท่านั้น',
          'start_date.required' => 'กรุณาเลือกวันเริ่มต้น',
          'end_date.required' => 'กรุณาเลือกวันสิ้นสุด',
          'permalink.required' => 'กรุณากรอก URL ของประเภททัวร์',

      ]);

      if ( $validator->fails() ) {

          $arr['code'] = 422;
          $arr['errors'] = $validator->errors();
      }
      else
      {
        $Fn = new FN;
        $start_date =  $Fn->q('date')->convertDate_th($request->start_date);
        $end_date =  $Fn->q('date')->convertDate_th($request->end_date);

          // store
          $data = new TourCategory;

          $data->name           = $request->name;
          $data->description    = $request->description;
          $data->status         = $request->status;
          $data->start_date     = $start_date;
          $data->end_date       = $end_date;
          $data->permalink      = $this->fn->q('text')->createPrimaryLink( $request->permalink );

          $data->created_uid    = Auth::user()->id;
          $data->updated_uid    = Auth::user()->id;

          $data->cid            = Session::get('cid');
          $data->seq            = 0;


          if($request->has('image')){
              $data->image = $request->file('image')->store( Session::get('cid'), 'public' );
              // $data->image = Storage::putFile('public/'.Session::get('cid'), $request->file('image'));

              //$request->file('image')->store( Session::get('cid'), 'public' );
          }

          if( $data->save() ){
              $arr['code'] = 200;
              $arr['message'] = 'บันทึกเรียบร้อย';
              // $arr['redirect'] = 'refresh';

              $arr['call'] = 'refreshDatatable';
          }
          else{
              $arr['code'] = 422;
              $arr['message'] = 'บันทึกข้อมูลล้มเหล่ว, กรุณาลองใหม่';
          }
      }

      return response()->json($arr, $arr['code']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $data = TourCategory::find( $id );
      if( is_null( $data ) ){
          return response()->json(["message" => 'Record not found!'], 404);
      }

      return view('forms.tours.category.add')->with('item', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

      $data = TourCategory::find( $id );
      if( is_null( $data ) ){
          return response()->json(["message" => 'Record not found!'], 404);
      }

      $validator = Validator::make($request->all(), [
          'name' => 'required|max:75',
          'end_date' => 'required',
          'start_date' => 'required',
          'permalink' => 'required',
          'image' => 'mimes:jpeg,jpg,png | max:1000',
      ],[
          'name.required' => 'กรุณากรอกชื่อเส้นทาง',

          'image.max' => 'ขนาดไฟล์เกินกำหนด',
          'image.mimes' => 'ชนิดของไฟล์ต้องเป็น jpeg,jpg,png เท่านั้น',
          'start_date.required' => 'กรุณาเลือกวันเริ่มต้น',
          'end_date.required' => 'กรุณาเลือกวันสิ้นสุด',
          'permalink.required' => 'กรุณากรอก URL ของประเภททัวร์',

      ]);

      if ( $validator->fails() ) {

          $arr['code'] = 422;
          $arr['errors'] = $validator->errors();
      }
      else
      {
        // $folder_path =
        if(!empty($data->image) && ($request->has('image') || $request->_image) ){

            Storage::disk('public')->delete($data->image);
            $data->image = '';
        }

        if($request->has('image')){
            $data->image = $request->file('image')->store( Session::get('cid'), 'public' );
        }


        $Fn = new FN;
        $start_date =  $Fn->q('date')->convertDate_th($request->start_date);
        $end_date =  $Fn->q('date')->convertDate_th($request->end_date);

          // store


          $data->name           = $request->name;
          $data->description    = $request->description;
          $data->status         = $request->status;
          $data->start_date     = $start_date;
          $data->end_date       = $end_date;
          $data->permalink      = $this->fn->q('text')->createPrimaryLink( $request->permalink );

          $data->created_uid    = Auth::user()->id;
          $data->updated_uid    = Auth::user()->id;

          $data->cid            = Session::get('cid');
          $data->seq            = 0;


          if( $data->save() ){
              $arr['code'] = 200;
              $arr['message'] = 'บันทึกเรียบร้อย';
              // $arr['redirect'] = 'refresh';

              $arr['call'] = 'refreshDatatable';
          }
          else{
              $arr['code'] = 422;
              $arr['message'] = 'บันทึกข้อมูลล้มเหล่ว, กรุณาลองใหม่';
          }
      }

      return response()->json($arr, $arr['code']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $data = TourCategory::find($id);
      if( is_null( $data ) ){
          return response()->json(["message" => 'Record not found!'], 404);
      }

      // $arr['update'] = ['[blog-category-id='.$id.']', $data];
      // $arr['call'] = 'refreshDatatable';

      if( !empty($data->image) ){
          Storage::disk('public')->delete($data->image);
      }

      $data->delete();
      return response()->json([
          "message" => 'ลบข้อมูลเรียบร้อย',
          'code' => 200,
          'info' => 'Successfully deleted.',

          // 'delete' => '[blog-category-id='.$id.']',
          'call' => 'refreshDatatable',

      ], 200);
    }

    public function delete($id)
    {
        $data = TourCategory::find( $id );
        if( is_null( $data ) ){
            return response()->json(["message" => 'Record not found!'], 404);
        }

        return view('forms.tours.category.delete')->with('item', $data);
    }

}
