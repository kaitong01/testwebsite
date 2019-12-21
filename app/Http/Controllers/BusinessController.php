<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


class BusinessController extends Controller
{
    public function index(Request $request, $tab='settings' )
    {
        // dd( $request );
        return view('pages.business.index')->with([
            'page_current_tab' => '/business/'.$tab,
            'item' => $request->user()->company,
        ]);
    }

    public function update(Request $request, $tab)
    {
        // $arr['post'] = $request->all();
        $validate = []; $validateMessage = [];

        if($tab=='settings'){
            $validate = [
                'name' => 'required|max:75',
                // 'description' => 'required',
                'image' => 'mimes:jpeg,jpg,png|max:1000',
            ];

            $validateMessage = [
                'name.required' => 'กรุณากรอกชื่อธุรกิจหรือเว็บไซต์ของคุณ',
                'name.max' => 'ชื่อต้องไม่เกิน 175 ตัวอักษร',
                'name.min' => 'ชื่อต้องยาว 2 ตัวอักษรขึ้นไป',

                'description.required' => 'กรุณากรอกคำอธิบาย',

                'image.required' => 'กรุณาใส่รูปภาพ',
                'image.mimes' => 'ชนิดของไฟล์ต้องเป็น .jpeg, .jpg, .png เท่านั้น',
                'image.max' => 'รับขนาดไฟล์สูงสุดที่จะอัปโหลดคือ 2MB',
            ];
        }

        $validator = Validator::make($request->all(), $validate, $validateMessage);

        if ( $validator->fails() ) {
            $arr['code'] = 422;
            $arr['errors'] = $validator->errors();
        }
        else{

            $data = $request->user()->company;

            if($tab=='settings'){

                $data->name           = $request->name;
                $data->hotline        = $request->hotline;
                $data->description    = $request->description;


                if(!empty($data->logo) && ($request->hasFile('logo') || $request->_logo) ){
                    Storage::disk('public')->delete($data->logo);
                    $data->logo = '';
                }

                if($request->hasFile('logo')){
                    $data->logo = $request->file('logo')->store( $request->user()->company->id.'/logos', 'public' );
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

                $arr['redirect'] = 'refresh';

                // $arr['update'] = ['[company-id='.$id.']', $data];
            }
            else{
                $arr['code'] = 422;
                $arr['message'] = 'บันทึกข้อมูลล้มเหล่ว, กรุณาลองใหม่';
            }

        }

        return response()->json($arr, $arr['code']);

        // return
    }
}
