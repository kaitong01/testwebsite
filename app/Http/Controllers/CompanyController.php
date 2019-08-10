<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Session\Store;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

use DB;
use App\Company;

class CompanyController extends Controller
{
    public static function is()
    {
        $id = Auth::user()->company_id;

        if( $id==0 ){

            $id = Session::get('cid');

            if( !isset($id) ){
                
                $company = CompanyController::first();
                // dd($company);
                $id = $company->co_id;
                Session::get('cid', $id);
            }

            // 
            $company = CompanyController::get( $id );

            if( empty($company) ){

                
                $company = CompanyController::first();
                $id = $company->co_id;

                Session::put('cid', $id);
            }
        }

        $results = CompanyController::get( $id );
        if( !empty($results) ){

            return true;
        }
        else{
            return false;
        }
    }
    
    public static function first()
    {
        return DB::table('companies')
            ->where('co_status','=',1)
            ->orderby( 'co_updated', 'desc' )
            ->first();
    }

    public static function get($id)
    {
        return DB::table('companies')
            ->where('co_status','=',1)
            ->where('co_id','=', $id)
            ->first();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
