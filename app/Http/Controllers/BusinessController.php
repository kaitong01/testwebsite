<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

use App\Models\Companies;
use App\Models\CompaniesSlidesModel;
use Illuminate\Support\Facades\Auth;

use function GuzzleHttp\json_encode;

class BusinessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( $tab='settings' )
    {
        $id = Session::get('cid');
        $data = Companies::find( $id );

        // if( is_null( $data ) ){
        //     return response()->json(["message" => 'Record not found!'], 404);
        // }

        return view('pages.business.index')->with([
            'page_current_tab' => '/business/'.$tab,
            'item' => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $tab)
    {
        // $arr['post'] = $request->all();
        $validate = [];
        $validateMessage = [];

        if($tab=='settings'){
            $validate = [
                'name' => 'required|max:75',
                // 'description' => 'required',
                // 'image' => 'required | mimes:jpeg,jpg,png | max:1000',
            ];

            $validateMessage = [
                'name.required' => 'กรุณากรอกชื่อธุรกิจหรือเว็บไซต์ของคุณ',
                'description.required' => 'กรุณากรอกคำอธิบาย',
                'image.required' => 'กรุณาใส่รูปภาพ',
                'image.max' => 'ขนาดไฟล์เกินกำหนด',
                'image.mimes' => 'ชนิดของไฟล์ต้องเป็น jpeg,jpg,png เท่านั้น',
            ];
        }



        $validator = Validator::make($request->all(), $validate, $validateMessage);
        if ( $validator->fails() ) {
            $arr['code'] = 422;
            $arr['errors'] = $validator->errors();
        }
        else{

            $id = Session::get('cid');
            $data = Companies::find( $id );

            if( is_null( $data ) ){
                return response()->json(["message" => 'Record not found!'], 404);
            }


            if($tab=='settings'){

                $data->name           = $request->name;
                $data->hotline        = $request->hotline;
                $data->description    = $request->description;


                if(!empty($data->logo) && ($request->hasFile('logo') || $request->_logo) ){
                    Storage::disk('public')->delete($data->logo);
                    $data->logo = '';
                }

                if($request->hasFile('logo')){
                    $data->logo = $request->file('logo')->store( Session::get('cid'), 'public' );
                }
            }

            if($tab=='contacts'){

                $contacts = array();
                $contactsDefault = ['email','phone','line','fax'];

                foreach ($request->contacts as $type => $value) {
                    if( empty($value) ) continue;

                    foreach ($value as $i => $val) {
                        if( is_null( $val ) ) continue;

                        if($i==0 && in_array($type, $contactsDefault)){
                            $data[$type] = $val;
                        }

                        $contacts[ $type ][] = $val;
                    }
                }

                $data->contacts_json = !empty($contacts)? json_encode( $contacts ): '';
            }

            if($tab=='locations'){
                $data->location_address         = $request->location_address;
                $data->location_district        = $request->location_district;
                $data->location_city            = $request->location_city;
                $data->location_province        = $request->location_province;
                $data->location_zip             = $request->location_zip;

            }


            if( $tab=='officehours' ){
                $data->officehours         = $request->officehours;

                if( $request->has('officehours_days')  ){
                    $data->officehours_days = json_encode($request->officehours_days);

                }
            }

            if( $tab=='seo' ){

                $data->seo_title         = $request->seo_title;
                $data->seo_description   = $request->seo_description;
                $data->seo_keywords      = $request->seo_keywords;


            }

            if( $tab=='google_analytics' ){
                $data->google_analytics_id         = $request->google_analytics_id;
            }

            if( $tab=='google_ads' ){
                $data->google_conversion_id         = $request->google_conversion_id;
            }

            if( $tab=='facebook_pixel' ){
                $data->facebook_pixel_code         = $request->facebook_pixel_code;
            }

            if( $data->update() ){
                $arr['code'] = 200;
                $arr['message'] = 'บันทึกข้อมูลเรียบร้อย';

                $arr['update'] = ['[company-id='.$id.']', $data];
            }
            else{
                $arr['code'] = 422;
                $arr['message'] = 'บันทึกข้อมูลล้มเหล่ว, กรุณาลองใหม่';
            }

        }

        return response()->json($arr, $arr['code']);

        // return
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
