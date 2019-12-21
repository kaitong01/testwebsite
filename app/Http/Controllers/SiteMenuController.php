<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SitePageRequest;
use App\Models\SitePage;
use App\Models\SitePageDefault;
use Illuminate\Support\Facades\Auth;

class SiteMenuController extends Controller
{
    public function create()
    {
        return view('forms.site.menu.form')->with([
            'statusList' => SitePage::status()
        ]);
    }

    public function store(SitePageRequest $request)
    {
        $data = new SitePage;

        if( $data->fill( $request->input() )->save() ){

            $data->company_id = Auth::user()->company->id;

            if($request->has('permalink')){
                $data->permalink = $this->fn->q('text')->createPermalink($request->permalink);
            }
            else{
                $data->permalink = $this->fn->q('text')->createPermalink($request->name);
            }

            $lastSeq = SitePage::where('company_id', '=', Auth::user()->company->id )->orderby('seq', 'desc')->first();
            if( !empty($lastSeq) ){
                $seq = $lastSeq->seq+1;
            }else{
                $seq = 0;
            }

            $data->seq = $seq;
            $data->update();

            $res['data'] = $data;
            $res['code'] = 200;
            $res['message'] = 'บันทึกข้อมูลแล้ว';
        }
        else{
            $res['code'] = 402;
            $res['message'] = 'บันทึกข้อมูลล้มเหลว, กรุณาลองใหม่';
        }

        return response()->json($res, $res['code']);
    }

    public function edit(Request $request, $id)
    {
        $statusList = SitePage::status();
        $lock = 0; $is_default = false;
        $type = !empty($request->type)? $request->type : null;

        if( empty($type) ){
            $data = SitePage::findOrFail($id);

        }
        else{
            $is_default = true;
            $default = SitePageDefault::findOrFail($type);

            $data = SitePage::where([
                ['type', '=', $type],
                ['company_id', '=', Auth::user()->company->id],
            ])->first();

            if( empty( $data ) ){
                $data = $default;
                $lock = 1;
            }
        }

        return view('forms.site.menu.form', compact('statusList', 'data', 'lock', 'is_default'));
    }
    public function update(SitePageRequest $request, $id)
    {
        if( $request->has('id') ){
            $data = SitePage::findOrFail($request->id);
        }
        else{
            $data = new SitePage;
        }

        if( $data->fill( $request->input() )->save() ){

            $data->company_id = Auth::user()->company->id;
            if($request->has('permalink')){
                $data->permalink = $this->fn->q('text')->createPermalink($request->permalink);
            }
            else{
                $data->permalink = $this->fn->q('text')->createPermalink($request->name);
            }

            $data->update();

            $res['data'] = $data;
            $res['code'] = 200;
            $res['message'] = 'บันทึกข้อมูลแล้ว';
        }
        else{
            $res['code'] = 402;
            $res['message'] = 'บันทึกข้อมูลล้มเหลว, กรุณาลองใหม่';
        }

        return response()->json($res, $res['code']);
    }

    public function sort(Request $request)
    {
        $types = $request->types;
        $ids = [];

        foreach ($request->ids as $seq => $id) {


            if( $id>0 ){
                $data = SitePage::find($id);
            }
            $type = isset($types[$seq])? $types[$seq]: 0;

            if( !empty($data) ){


                $data->seq = $seq;
                $data->update();

                array_push($ids, $id);
            }
            else if( $type>0 ) {

                $data = SitePage::where( [
                    ['company_id', '=', Auth::user()->company->id],
                    ['type', '=', $type]
                ] )->first();

                if( !empty($data) ){

                    $data->seq = $seq;
                    $data->update();

                    array_push($ids, $data->id);
                }
                else{

                    $default = SitePageDefault::findOrFail($type);

                    if( !empty($default) ){

                        $data = new SitePage;

                        $data->type = $default->id;
                        $data->name = $default->name;
                        $data->company_id = Auth::user()->company->id;
                        $data->permalink = $this->fn->q('text')->createPermalink($default->name);
                        $data->seq = $seq;

                        $data->save();
                        array_push($ids, $data->id);
                    }
                }
            }
        }

        $res['code'] = 200;
        $res['message'] = 'บันทึกข้อมูลแล้ว';
        $res['ids'] = $ids;

        return response()->json($res, $res['code']);
    }
}
