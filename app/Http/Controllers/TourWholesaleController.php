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
use App\Models\TourWholesale;

class TourWholesaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $db = TourWholesale::where('cid','=',Session::get('cid'))->first();
      if($db!==null){
        $arr = json_decode($db->wholesale);
        $data = DB::table('wholesales')
        ->whereIn('id',$arr)
        ->get();
      }else{
        $data = null;
      }
      return view('pages.settings')->with([
          'data' => $data,
          'wholesale' =>'' ,
          'page_current_tab' => '/settings/tours/wholesale'
      ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('forms.tours.wholesale.add');
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
          'wholesale_id' => 'required',
      ],[
          'wholesale_id.required' => 'กรุณาเลือกโฮลเซลล์',
      ]);

      if ( $validator->fails() ) {
          $arr['code'] = 422;
          $arr['errors'] = $validator->errors();
      }
      else
      {
        //กำหนดจำนวนโฮลเซล
        $limit_wholesale = 10;
        if(count($request->wholesale_id)>$limit_wholesale){

          $arr['code'] = 422;
          $arr['message'] = 'โฮลเซลล์ที่เลือกต้องไม่เกินจำนวน '.$limit_wholesale.' โฮลเซลล์';
        }else{
          $w_id = json_encode($request->wholesale_id);
          // store
          if($request->cid){
            $data = DB::table('tour_wholesale')
            ->where('cid','=',$request->cid)
            ->first();
            $id_ = $data->id;
            $data = TourWholesale::find($id_);
            $data->created_uid    = Auth::user()->id;
            $data->updated_uid    = Auth::user()->id;
            $data->wholesale        = $w_id;
            if( $data->save() ){
                $arr['code'] = 200;
                $arr['message'] = 'บันทึกเรียบร้อย';
                // $arr['redirect'] = 'refresh';

              $arr['redirect'] = 'refresh';
            }
            else{
                $arr['code'] = 422;
                $arr['message'] = 'บันทึกข้อมูลล้มเหลว, กรุณาลองใหม่';
            }
          }else{
            $data = new TourWholesale;


            // $data->status         = $request->status;

            $data->created_uid    = Auth::user()->id;
            $data->updated_uid    = Auth::user()->id;
            $data->wholesale        = $w_id;
            $data->cid            = Session::get('cid');
            $data->seq        = 0;





            if( $data->save() ){
                $arr['code'] = 200;
                $arr['message'] = 'บันทึกเรียบร้อย';
                // $arr['redirect'] = 'refresh';

                $arr['redirect'] = 'refresh';
            }
            else{
                $arr['code'] = 422;
                $arr['message'] = 'บันทึกข้อมูลล้มเหลว, กรุณาลองใหม่';
            }
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
