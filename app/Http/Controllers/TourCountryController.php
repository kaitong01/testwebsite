<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

use DB;
use App\Library\Fn;

use App\Library\Form;
use Illuminate\Support\Facades\Storage;
use App\Models\TourCountry;

class TourCountryController extends Controller
{
    // protected $table = 'tour_country';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('pages.settings')->with([
            'country' =>'' ,
            'page_current_tab' => '/settings/tours/country'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
          return view('forms.tours.country.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

      $validator = Validator::make($request->all(), [
          'country_id' => 'required',
      ],[
          'country_id.required' => 'กรุณาเลือกประเทศ',
      ]);

      if ( $validator->fails() ) {

          $arr['code'] = 422;
          $arr['errors'] = $validator->errors();
      }
      else
      {

          $c_id = json_encode($request->country_id);
          // store




          if($request->cid){

          }else{
            $data = new TourCountry;


            // $data->status         = $request->status;

            $data->created_uid    = Auth::user()->id;
            $data->updated_uid    = Auth::user()->id;
            $data->country        = $c_id;
            $data->cid            = Session::get('cid');
            $data->seq        = 0;



            if($request->has('image')){
                $data->image = $request->file('image')->store( Session::get('cid'), 'public' );
                // $data->image = Storage::putFile('public/'.Session::get('cid'), $request->file('image'));

                //$request->file('image')->store( Session::get('cid'), 'public' );
            }

            if( $data->save() ){
                $arr['code'] = 200;
                $arr['message'] = 'บันทึกเรียบร้อย';
                // $arr['redirect'] = 'refresh';

                $arr['call'] = 'refreshDatatable';
            }
            else{
                $arr['code'] = 422;
                $arr['message'] = 'บันทึกข้อมูลล้มเหล่ว, กรุณาลองใหม่';
            }
        }

            return response()->json($arr, $arr['code']);
          }

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
    public function update(Request $request, $id)
    {
        //
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
