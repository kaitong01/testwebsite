<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

// use Faker\Provider\Image;
use Illuminate\Support\Facades\Storage;
use App\Library\Fn;
// use App\Library\Form;

use App\Models\BlogsPost;

class BlogsAddController extends Controller
{
  protected $table = 'blog_post';

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
      // $model = new BlogsCategoryModel;
      // $model->_find();

      // dd($this->_company);

      $ops = array(
          'sort' => isset($request->sort)? $request->sort: 'updated_at',
          'dir' => isset($request->dir)? $request->dir: 'desc',

          'limit' => isset($request->limit)? $request->limit: 2,
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

      $arr['items'] = $this->ui->q('BlogPostUi')->init($arr['data'], $arr['options']);

      return response()->json($arr, 200);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {

      return view('forms.blogs.post.add');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {

      $arr = array();

      $validator = Validator::make($request->all(), [
          'name' => 'required|max:75',
          'highlight' => 'required',
          'author' => 'required',
          'start_date' => 'required',
          'end_date' => 'required',
          'author' => 'required',
          'text' => 'required',
          'image' => 'required | mimes:jpeg,jpg,png | max:1000',
      ],[
          'name.required' => 'กรุณากรอกข้อมูลหัวเรื่อง',
          'highlight.required' => 'กรุณากรอกไฮไลท์บทความ',
          'author.required' => 'กรุณากรอกชื่อผู้เขียน',
          'text.required' => 'กรุณากรอกรายละเอียดบทความ',

          'description.required' => 'กรุณากรอกคำอธิบาย',
          'image.required' => 'กรุณาใส่รูปภาพ',
          'image.max' => 'ขนาดไฟล์เกินกำหนด',
          'image.mimes' => 'ชนิดของไฟล์ต้องเป็น jpeg,jpg,png เท่านั้น',
      ]);

      if ( $validator->fails() ) {

          $arr['code'] = 422;
          $arr['errors'] = $validator->errors();
      }
      else{

          // dd($request);

          $Fn = new FN;
          $start_date =  $Fn->q('date')->convertDate_th($request->start_date);
          $end_date =  $Fn->q('date')->convertDate_th($request->end_date);
          // store
          $data = new BlogsPost;

          $data->name           = $request->name;
          $data->highlight      = $request->highlight;
          $data->status         = $request->status;
          $data->category_id    = $request->category_id;
          $data->start_date     = $start_date;
          $data->end_date       = $end_date;
          $data->author       = $request->author;
          $data->text       = $request->text;


          $data->seo_title      = $request->seo_title;
          $data->seo_description= $request->seo_description;
          $data->permalink      = $this->fn->q('text')->createPrimaryLink( $request->permalink );

          $data->created_uid    = Auth::user()->id;
          $data->updated_uid    = Auth::user()->id;

          $data->cid            = Session::get('cid');


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

  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
      $data = BlogsPost::find( $id );
      if( is_null( $data ) ){
          return response()->json(["message" => 'Record not found!'], 404);
      }

      return view('forms.blogs.post.add')->with('item', $data);
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

      $data = BlogsPost::find( $id );


      if( is_null( $data ) ){
          return response()->json(["message" => 'Record not found!'], 404);
      }



      $arr = array();


      $validator = Validator::make($request->all(), [
          'name' => 'required|max:75',
          'highlight' => 'required',
          'author' => 'required',
          'start_date' => 'required',
          'end_date' => 'required',
          'author' => 'required',
          'text' => 'required',
          'image' => 'mimes:jpeg,jpg,png | max:1000',
      ],[
          'name.required' => 'กรุณากรอกข้อมูลหัวเรื่อง',
          'highlight.required' => 'กรุณากรอกไฮไลท์บทความ',
          'author.required' => 'กรุณากรอกชื่อผู้เขียน',
          'text.required' => 'กรุณากรอกรายละเอียดบทความ',

          'description.required' => 'กรุณากรอกคำอธิบาย',

          'image.max' => 'ขนาดไฟล์เกินกำหนด',
          'image.mimes' => 'ชนิดของไฟล์ต้องเป็น jpeg,jpg,png เท่านั้น',
      ]);

      if ( $validator->fails() ) {

          $arr['code'] = 422;
          $arr['errors'] = $validator->errors();
      }
      else{

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

          $data->name           = $request->name;
          $data->highlight      = $request->highlight;
          $data->status         = $request->status;
          $data->category_id    = $request->category_id;
          $data->start_date     = $start_date;
          $data->end_date       = $end_date;
          $data->author       = $request->author;
          $data->text       = $request->text;


          $data->seo_title      = $request->seo_title;
          $data->seo_description= $request->seo_description;
          $data->permalink      = $this->fn->q('text')->createPrimaryLink( $request->permalink );

          $data->updated_uid    = Auth::user()->id;



          if( $data->update() ){
              $arr['code'] = 200;
              $arr['message'] = 'บันทึกข้อมูลเรียบร้อย';
              // $arr['redirect'] = 'refresh';

              $arr['update'] = ['[blog-category-id='.$id.']', $data];
              $arr['call'] = 'refreshDatatable';
          }
          else{
              $arr['code'] = 422;
              $arr['message'] = 'บันทึกข้อมูลล้มเหล่ว, กรุณาลองใหม่';
          }
      }

      return response()->json($arr, $arr['code']);
  }



  public function delete($id)
  {
    
      $data = BlogsPost::find($id);
      if( is_null( $data ) ){
          return response()->json(["message" => 'Record not found!'], 404);
      }

      return view('forms.blogs.post.delete')->with('item', $data);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(Request $request, $id)
  {
      $data = BlogsPost::find($id);
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
}
