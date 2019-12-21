<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BlogCategoryRequest;
use App\Models\BlogCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BlogCategoryController extends Controller
{
    public function index(Request $request)
    {
        $ops = [
            'sort' => isset($request->sort)? $request->sort: 'updated_at',
            'dir' => isset($request->dir)? $request->dir: 'desc',

            'limit' => isset($request->limit)? $request->limit: 1,
            'page' => isset($request->page)? $request->page: 1,

            'ts' =>  isset($request->ts)? $request->ts: time(),
        ];

        $where = [];

        if( $request->has('status') ){
            if( $request->status!='' ){
                $where[] = ['status', '=', $request->status];
            }
        }

        $where[] = ['company_id', '=', Auth::user()->company->id ];


        $results = BlogCategory::where($where)

            ->orderby( $ops['sort'], $ops['dir'] )

            ->skip( ($ops['page']*$ops['limit'])-$ops['limit'])
            ->take( $ops['limit'] )

            ->paginate( $ops['limit'] );

        $res = [
            'options' => $ops,
            'total' => $results->total(),
            'data' => $results->items(),
        ];


        $res['code'] = 200;
        $res['info'] = 'Results successfully';
        $res['message'] = 'The request has succeeded.';

        // dd($res);
        $res['items'] = $this->ui->item('BlogCategoryDatatable')->init( $res['data'], $res['options'] );

        return response()->json($res, 200);
    }

    public function create()
    {
        return view('forms.blogs.category.form')->with([
            'statusList' => BlogCategory::status()
        ]);
    }

    public function store(BlogCategoryRequest $request)
    {

        $data = new BlogCategory();
        if( $data->fill( $request->input() )->save() ){

            // update permalink
            if($request->has('permalink')){
                $data->permalink = $this->fn->q('text')->createPermalink($request->permalink);
            }
            else{
                $data->permalink = $this->fn->q('text')->createPermalink($request->name);
            }


            if($request->has('image')){
                $data->image = $request->file('image')->store( "{$request->company_id}/blogs-categories/" , 'public' );
            }


            $data->update();


            $res['data'] = [
                'id' => $data->id
            ];
        }

        $res['code'] = 200;
        $res['message'] = 'บันทึกข้อมูลแล้ว';
        return response()->json($res, 200);
    }


    public function edit($id)
    {
        $data = BlogCategory::findOrFail($id);


        return view('forms.blogs.category.form')->with([
            'data' => $data,
            'statusList' => BlogCategory::status()
        ]);
    }
    public function update(BlogCategoryRequest $request)
    {
        $data = BlogCategory::findOrFail($request->id);

        if( $data->fill( $request->input() )->save() ){


            // update permalink
            if($request->has('permalink')){
                $data->permalink = $this->fn->q('text')->createPermalink($request->permalink);
            }
            else{
                $data->permalink = $this->fn->q('text')->createPermalink($request->name);
            }

            // ลบรูปเดิม
            if(!empty($data->image) && ($request->has('image') || $request->has('image_cancel_file')) ){
                Storage::disk('public')->delete($data->image);
                $data->image = null;
            }

            if($request->has('image')){
                $data->image = $request->file('image')->store( "{$request->company_id}/blogs-categories/" , 'public' );
            }

            $data->update();

            $res['data'] = [
                'id' => $data->id
            ];
        }

        $res['code'] = 200;
        $res['message'] = 'บันทึกข้อมูลแล้ว';
        return response()->json($res, 200);
    }


    public function switch(Request $request)
    {
        $data = BlogCategory::findOrFail($request->id);

        if( $data->fill( $request->input() )->save() ){
            $res['data'] = [
                'id' => $data->id
            ];

            $res['code'] = 200;
            $res['message'] = 'บันทึกข้อมูลแล้ว';
        }
        else{
            $res['code'] = 402;
            $res['message'] = 'บันทึกข้อมูลล้มเหลว, กรุณาลองใหม่';
        }

        return response()->json($res, $res['code']);
    }
}
