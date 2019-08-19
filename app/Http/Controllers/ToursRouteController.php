<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

use DB;
use App\Library\Fn;

use App\Library\Form;

use App\Models\ToursRoute;

class ToursRouteController extends Controller
{
    protected $table = 'tour_route';
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

      $arr['items'] = $this->ui->req('Item_TourRoute')->init($arr['data'], $arr['options']);

      return response()->json($arr, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('forms.tours.route.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:75',
            'country_id' => 'required',
            'image' => 'required | mimes:jpeg,jpg,png | max:1000',
        ],[
            'name.required' => 'กรุณากรอกชื่อเส้นทาง',
            'description.required' => 'กรุณากรอกคำอธิบาย',
            'image.required' => 'กรุณาใส่รูปภาพ',
            'image.max' => 'ขนาดไฟล์เกินกำหนด',
            'image.mimes' => 'ชนิดของไฟล์ต้องเป็น jpeg,jpg,png เท่านั้น',
            'country_id.required' => 'กรุณาเลือกประเทศ',

        ]);

        if ( $validator->fails() ) {

            $arr['code'] = 422;
            $arr['errors'] = $validator->errors();
        }
        else{

            $c_id ="";
            foreach ($request->country_id as $key =>  $row) {
              if($key==0){
                $c_id .= $request->country_id[$key];
              }else{
                $c_id .= ",".$request->country_id[$key];
              }
            }
            $c_id ="[".$c_id."]";


            // store
            $data = new ToursRoute;

            $data->name           = $request->name;
            $data->description    = $request->description;
            // $data->status         = $request->status;


            $data->seo_title      = $request->seo_title;
            $data->seo_description= $request->seo_description;
            $data->permalink      = $this->fn->q('text')->createPrimaryLink( $request->permalink );

            $data->created_uid    = Auth::user()->id;
            $data->updated_uid    = Auth::user()->id;
            $data->country        = $c_id;
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
