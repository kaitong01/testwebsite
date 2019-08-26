<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


use App\Models\Companies;
use App\Models\WholesaleSeries;

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

            return view('pages.store.find');
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
