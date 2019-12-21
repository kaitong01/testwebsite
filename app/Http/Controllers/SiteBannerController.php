<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CompanyBanner;
use Illuminate\Support\Facades\Storage;

class SiteBannerController extends Controller
{
    public function store(Request $request)
    {
        if( $request->has('id') ){
            $data = CompanyBanner::find($request->id);
        }
        else{
            $data = new CompanyBanner;
        }

        if( $data->fill( $request->input() )->save() ){

            // remove file

            if( $request->has('file1')||$request->has('file1_cancel_file') && !empty($data->path) ){
                Storage::disk('public')->delete($data->path);
                $data->path = null;
            }

            // update new file
            if( $request->has('file1') ){
                $data->path = $request->file('file1')->store( $request->user()->company->id. "/banners/", 'public');
            }

            $data->company_id = $request->user()->company->id;
            $data->update();


            $arr['data'] = $data;
            $arr['code'] = 200;
            $arr['message'] = 'บันทึกข้อมูลแล้ว';
            $arr['redirect'] = 'refresh';
        }
        else{

            $arr['code'] = 402;
            $arr['errors'] = $arr['errors'];
            $arr['message'] = 'บันทึกข้อมูลล้มเหลว, กรุณาลองใหม่';

        }

        return response()->json($arr, $arr['code']);
    }
}
