<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

use DB;
use App\Library\Fn;
use App\Library\Form;

use App\Models\BlogsCategoryModel;


class BlogsCategoryController extends Controller
{
    protected $table = 'blog_category';

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

        $arr['items'] = $this->ui->req('Item_BlogCategory')->init($arr['data'], $arr['options']);

        return response()->json($arr, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('forms.blogs.category.add');
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
        ],[
            'name.required' => 'กรุณากรอกข้อมูลหัวเรื่อง',
        ]);

        if ( $validator->fails() ) {

            $arr['code'] = 422;
            $arr['errors'] = $validator->errors();
        }
        else{

            $data = new BlogsCategoryModel;

            $data->name           = $request->name;
            $data->description    = $request->description;
            $data->status         = $request->status;


            $data->seo_title      = $request->seo_title;
            $data->seo_description= $request->seo_description;
            $data->permalink      = $this->fn->q('text')->createPrimaryLink( $request->link );

            $data->created_uid    = Auth::user()->id;
            $data->updated_uid    = Auth::user()->id;

            $data->cid            = Session::get('cid');

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
        $data = BlogsCategoryModel::find( $id );
        if( is_null( $data ) ){
            return response()->json(["message" => 'Record not found!'], 404);
        }

        return view('forms.blogs.category.add')->with('item', $data);
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
        $data = BlogsCategoryModel::find( $id );

        if( is_null( $data ) ){
            return response()->json(["message" => 'Record not found!'], 404);
        }

        $arr = array();
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:75',
        ],[
            'name.required' => 'กรุณากรอกข้อมูลหัวเรื่อง',
        ]);

        if ( $validator->fails() ) {

            $arr['code'] = 422;
            $arr['errors'] = $validator->errors();
        }
        else{

            $data->name           = $request->name;
            $data->description    = $request->description;
            $data->status         = $request->status;

            $data->seo_title      = $request->seo_title=='' ? $request->name: $request->seo_title;
            $data->seo_description= $request->seo_description;
            $data->permalink      = $this->fn->q('text')->createPrimaryLink( $request->link );

            $data->updated_uid    = Auth::user()->id;

            if( $data->update() ){
                $arr['code'] = 200;
                $arr['message'] = 'บันทึกข้อมูลเรียบร้อย';
                // $arr['redirect'] = 'refresh';

                $arr['update'] = ['[blog-category-id='.$id.']', $data];
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
        $data = BlogsCategoryModel::find( $id );
        if( is_null( $data ) ){
            return response()->json(["message" => 'Record not found!'], 404);
        }

        return view('forms.blogs.category.delete')->with('item', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $data = BlogsCategoryModel::find($id);
        if( is_null( $data ) ){
            return response()->json(["message" => 'Record not found!'], 404);
        }

        $arr['update'] = ['[blog-category-id='.$id.']', $data];

        $arr['call'] = 'refreshDatatable';

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
