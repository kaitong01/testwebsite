<?php

namespace App\Http\Controllers;
// use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


use App\Models\Companies;
use App\Models\WholesaleSeries;
use App\Models\Carts;
use DB;

class StoreController extends Controller
{

    public function index()
    {
        $wholesales = Companies::followedWholesale( Session::get('cid') );
        $wholesalesIds = array();
        foreach ($wholesales as $key => $value) {
            $wholesalesIds[] = $value->id;
        }


        $pecent = WholesaleSeries::get( ['sort'=> 'created_at', 'dir'=>'desc', 'limit'=>12, 'wholesales'=>$wholesales] );
        $periodLastWeek = WholesaleSeries::periodLastWeek( ['limit'=>6, 'wholesales'=>$wholesales] );

        // $discount = WholesaleSeries::discount( ['sort'=> 'created_at', 'dir'=>'desc', 'limit'=>6, 'wholesales'=>$wholesales] );
        // $popular = WholesaleSeries::search( ['sort'=> 'download_total', 'dir'=>'desc', 'limit'=>6, 'wholesales'=>$wholesales] );

        // dd($pecent);
        // $festival = WholesaleSeries::festival( ['limit'=>6] ); // เทศกาล
        // $holiday = WholesaleSeries::holiday( ['limit'=>6] ); // ตรงกับกวันหยุดไทย

        return view('pages.store.index')->with(compact('wholesales', 'periodLastWeek', 'pecent'));
    }
    public static function check_carts($id)
    {
      $carts = Carts::where('cid','=',Session::get('cid'))
      ->where('wh_series_id','=',$id)
      ->first();
      if(empty($carts)){
        $status ="";
      }else{
        $status = $carts->status;
      }
      return $status;
    }

    public function find($tab='')
    {

        return view('pages.store.find')->with([
            'page_current_tab' => '/settings/blogs/'.$tab
        ]);
    }
    public function wholesale($tab='')
    {
        return view('pages.store.find')->with([
            'page_current_tab' => '/settings/blogs/'.$tab
        ]);
    }
    public function detail($id='')
    {

        if(  in_array($id, ['discount', 'new', 'popular'] ) ){
          if($id=='new'){
            $wholesales = Companies::followedWholesale( Session::get('cid') );
            $data = WholesaleSeries::get( ['sort'=> 'created_at', 'dir'=>'desc', 'wholesales'=>$wholesales] );
            return view('pages.store.find')->with(compact('data'));
          }



        }
        else{
            $data = WholesaleSeries::once( $id );
            if( is_null( $data ) ){
                return view('errors/404');
                // return response()->json(["message" => 'Record not found!'], 404);
            }

            // dd($data);
            return view('pages.store.detail')->with(compact('data'));
        }

    }

    public function addtoCart(Request $request)
    {
      $id = $request->id;
      $cid = Session::get('cid');
      $db_cart = DB::table('carts')
      ->where('cid','=',$cid)
      ->where('wh_series_id','=',$id)
      ->first();
      if($db_cart!=null){
        $cart = Carts::find($db_cart->id);
        //Check status
        // 1.เพิ่มแล้ว
        if($cart->status==1){
          $cart->status = 0;
        }elseif($cart->status==0){
          $cart->status = 1;
        }
        $cart->cid = $cid;
        $cart->wh_series_id = $id;
        if($cart->save()){
          $status =   $cart->status;
        }else{
            $status =  'error';
        }


      }else{
        $cart = new Carts;
        $cart->cid = $cid;
        $cart->wh_series_id = $id;
        $cart->status = 1;
        if($cart->save()){
          $status =   $cart->status;
        }else{
          $status =  'error';
        }
      }
    $arr = [
    'status'=>$status,
  ];
    echo json_encode($arr);
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
        //
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
