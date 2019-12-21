<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RouteRequest;
use App\Models\CountryModel;
use App\Models\TourCountryModel;
use App\Models\TourRouteCountryModel;
use App\Models\TourRouteModel;
use Illuminate\Support\Facades\Storage;

class TourRouteController extends Controller
{
    public function index( TourRouteModel $db, Request $request )
    {
        $res = $db->find($request);

        $res['code'] = 200;
        $res['info'] = 'Results successfully';
        $res['message'] = 'The request has succeeded.';

        // dd($res);
        $res['items'] = $this->ui->item('TourRouteDatatable')->init( $res['data'], $res['options'] );

        return response()->json($res, 200);
    }

    public function create()
    {
        return view('forms.tours.route.form')->with([

            'countryList' => CountryModel::get()
        ]);
    }
    public function store(RouteRequest $request)
    {
        $res = [];

        $data = new TourRouteModel;
        if( $data->fill( $request->input() )->save() ){

            // update permalink
            if($request->has('permalink')){
                $data->permalink = $this->fn->q('text')->createPermalink($request->permalink);
            }
            else{
                $data->permalink = $this->fn->q('text')->createPermalink($request->name);
            }

            // update: image
            if($request->has('image')){
                $data->image = $request->file('image')->store( "{$request->company_id}/cities/" , 'public' );
            }

            // update join country list
            $countryList = !empty($request->country)? $request->country: [];
            foreach ($data->countries as $value) {

                if( !in_array($value->id, $countryList) ){

                    $country = TourRouteCountryModel::where([
                        ['route_id', '=', $data->id],
                        ['country_id', '=', $value->id],
                    ])->first();

                    if( !empty($country) ){
                        $country->delete();
                    }
                }
            }

            foreach ($countryList as $cid) {

                $country = TourRouteCountryModel::where([
                    ['route_id', '=', $data->id],
                    ['country_id', '=', $cid],
                ])->first();

                if( empty($country) ){
                    $country = new TourRouteCountryModel();
                }

                $country->route_id = $data->id;
                $country->country_id = $cid;
                $country->save();


                ## auto update country to company
                $country = TourCountryModel::where([
                    ['company_id', '=', $request->company_id],
                    ['country_id', '=', $cid],
                ])->first();

                if( empty($country) ){
                    $country = new TourCountryModel();

                    $country->company_id = $request->company_id;
                    $country->country_id = $cid;
                    $country->status = 1;
                    $country->save();
                }
            }

            $data->update();


            $res['code'] = 200;
            $res['info'] = '';
            $res['message'] = 'บันทึกข้อมูลเรียบร้อย';
        }
        else{
            $res['code'] = 402;
            $res['info'] = '';
            $res['message'] = 'บันทึกข้อมูลล้มเหลว, กรุณาลองใหม่';
        }

        return response()->json($res, $res['code']);
    }


    public function edit($id)
    {
        $data = TourRouteModel::findOrFail( $id );
        if( empty( $data ) ){
            return response()->json(["message" => 'Record not found!'], 404);
        }

        return view('forms.tours.route.form')->with([

            'countryList' => CountryModel::get(),
            'data' => $data,
        ]);
    }
    public function update(RouteRequest $request, $id)
    {
        $res = [];

        $data = TourRouteModel::findOrFail( $id );
        if( $data->fill( $request->input() )->update() ){

            // update permalink
            if($request->has('permalink')){
                $data->permalink = $this->fn->q('text')->createPermalink($request->permalink);
            }
            else{
                $data->permalink = $this->fn->q('text')->createPermalink($request->name);
            }


            // update image
            if(!empty($data->image) && ($request->has('image') || $request->has('image_cancel_file')) ){
                Storage::disk('public')->delete($data->image);
                $data->image = null;
            }
            if($request->has('image')){
                $data->image = $request->file('image')->store( "{$request->company_id}/cities/" , 'public' );
            }

            ## update join country list
            $countryList = !empty($request->country)? $request->country: [];
            foreach ($data->countries as $value) {

                if( !in_array($value->id, $countryList) ){

                    $country = TourRouteCountryModel::where([
                        ['route_id', '=', $data->id],
                        ['country_id', '=', $value->id],
                    ])->first();

                    if( !empty($country) ){
                        $country->delete();
                    }
                }
            }

            foreach ($countryList as $cid) {

                $country = TourRouteCountryModel::where([
                    ['route_id', '=', $data->id],
                    ['country_id', '=', $cid],
                ])->first();

                if( empty($country) ){
                    $country = new TourRouteCountryModel();
                }

                $country->route_id = $data->id;
                $country->country_id = $cid;
                $country->save();


                ## auto update country to company
                $country = TourCountryModel::where([
                    ['company_id', '=', $request->company_id],
                    ['country_id', '=', $cid],
                ])->first();

                if( empty($country) ){
                    $country = new TourCountryModel();

                    $country->company_id = $request->company_id;
                    $country->country_id = $cid;
                    $country->status = 1;
                    $country->save();
                }
            }

            $data->update();


            $res['code'] = 200;
            $res['info'] = '';
            $res['message'] = 'บันทึกข้อมูลเรียบร้อย';
        }
        else{
            $res['code'] = 402;
            $res['info'] = '';
            $res['message'] = 'บันทึกข้อมูลล้มเหลว, กรุณาลองใหม่';
        }

        return response()->json($res, $res['code']);
    }

    public function switch(Request $request)
    {
        $data = TourRouteModel::findOrFail($request->id);

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
