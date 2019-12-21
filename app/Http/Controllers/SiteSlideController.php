<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CompanySlide;
use Illuminate\Support\Facades\Storage;

class SiteSlideController extends Controller
{
    public function store(Request $request)
    {
        // dd($request->input());
        $oData = CompanySlide::where( 'company_id', '=', $request->user()->company->id )->get();
        $ids = [];

        $arr = []; $gallery = [];
        if($request->has('images')){

            // dd( $request->images );
            foreach ($request->images as $key => $item) {

                if( !empty($item['id']) ){
                    array_push($ids, $item['id']);
                    $data = CompanySlide::find( $item['id'] );
                }
                else{
                    $data = new CompanySlide;
                }

                $data->caption = !empty($item['caption'])? $item['caption']: null;
                $data->title = !empty($item['title'])? $item['title']: null;
                $data->permalink = !empty($item['permalink'])? $item['permalink']: null;
                $data->company_id = $request->user()->company->id;

                if( !empty($item['upload']) ){

                    $userfile = !empty($item['upload'])? $item['upload']: '';
                    $data->path = $userfile->store( $request->user()->company->id. "/slides/", 'public');
                    $data->original_name = $userfile->getClientOriginalName();
                }

                if( $data->save() ){

                }
                else{
                    $arr['errors']['images'][ $key ] = 'บันทึกข้อมูลล้มเหลว, กรุณาลองใหม่';
                }
            }
        }


        foreach( $oData as $item ){
            if( !in_array($item->id, $ids) ){

                $data = CompanySlide::findOrFail($item->id);

                if( !empty($data->path) ){
                    Storage::disk('public')->delete($data->path);
                }

                $data->delete();
            }
        }


        if( empty($arr['errors']) ){
            $arr['data'] = $gallery;
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
