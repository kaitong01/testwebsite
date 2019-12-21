<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TourWholesaleModel;

class TourWholesaleController extends Controller
{
    public function index(TourWholesaleModel $db, Request $request)
    {
        $res = $db->find($request);

        $res['code'] = 200;
        $res['info'] = 'Results successfully';
        $res['message'] = 'The request has succeeded.';

        // dd($res);
        $res['items'] = $this->ui->item('TourWholesaleDatatable')->init( $res['data'], $res['options'] );

        return response()->json($res, 200);
    }

    public function switch(Request $request)
    {

        if( $request->id==null ){
            $data = new TourWholesaleModel();
        }
        else{
            $data = TourWholesaleModel::findOrFail($request->id);
        }

        if( $data->fill( $request->input() )->save() ){
            $res['data'] = [
                'id' => $data->id
            ];

            $res['code'] = 200;
            $res['message'] = 'บันทึกข้อมูลแล้ว';
        }
        else{
            $res['code'] = 402;
            $res['message'] = 'บันทึกข้อมูลล้มเหลว, กรุณาลองใม่';
        }

        return response()->json($res, 200);
    }
}
