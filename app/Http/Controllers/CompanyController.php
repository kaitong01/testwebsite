<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Session\Store;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

use DB;
use App\Company;
// use App\Library\Business;

class CompanyController extends Controller
{
    public function is()
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


            $company = CompanyController::get( $id );
            if( empty($company) ){

                $company = CompanyController::first();
                $id = $company->co_id;
                // Session::put('cid', $id);
            }
        }

        $results = CompanyController::get( $id );   

        if( !empty($results) ){

            Session::put('cid', $id);
            // $this->_company = $results;
            // Business::set($results);
            // dd(Business::get());
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


}
