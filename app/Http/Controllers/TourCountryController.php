<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CountryModel;
use App\Models\TourCountryModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TourCountryController extends Controller
{

    public function index(TourCountryModel $db, Request $request)
    {
        $res = $db->find($request);

        $res['code'] = 200;
        $res['info'] = 'Results successfully';
        $res['message'] = 'The request has succeeded.';

        // dd($res);
        $res['items'] = $this->ui->item('TourCountryDatatable')->init( $res['data'], $res['options'] );

        return response()->json($res, 200);
    }

    public function edit($id)
    {
        $original = CountryModel::findOrFail( $id );
        if( empty( $original ) ){
            return response()->json(["message" => 'Record not found!'], 404);
        }

        $data = TourCountryModel::where([
            ['company_id', '=', Auth::user()->company->id],
            ['country_id', '=', $original->id],
        ])->first();

        return view('forms.tours.country.form')->with([
            'original' => $original,
            'data' => $data,
            'status' => TourCountryModel::status()
        ]);
    }


    public function store(Request $request)
    {
        if( !empty($request->id) ){
            $data = TourCountryModel::findOrFail($request->id);
        }
        else{
            $data = new TourCountryModel();
        }

        if( $data->fill( $request->input() )->save() ){

            // ลบรูปเดิม
            if(!empty($data->image) && ($request->has('file1') || $request->has('file1_cancel_file')) ){
                Storage::disk('public')->delete($data->image);
                $data->image = null;
            }

            if($request->has('file1')){
                $data->image = $request->file('file1')->store( "{$request->company_id}/countries/" , 'public' );
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
        if( $request->id==null ){
            $data = new TourCountryModel();
        }
        else{
            $data = TourCountryModel::findOrFail($request->id);
        }


        if( $data->fill( $request->input() )->save() ){


            if( empty($data->permalink)  ){

                if( !empty( $data->name ) ){
                    $data->permalink = $this->fn->q('text')->createPermalink($data->name);
                }
                else if( $request->has('country_id') ){
                    $country = CountryModel::find($request->country_id);
                    $name = !empty($country->name_th) ? $country->name_th: $country->name;
                    $data->permalink = $this->fn->q('text')->createPermalink($name);
                }

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


        return response()->json($res, 200);
    }
}
