<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Company;

class SiteFontController extends Controller
{
    public function store(Request $request)
    {
        $data = Company::find( $request->user()->company->id );

        if( $data->fill( $request->input() )->update() ){

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
}
