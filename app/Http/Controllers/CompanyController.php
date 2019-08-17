<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Session\Store;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// use App\Company;
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
                // Session::put('cid', $id);
            }

            $company = CompanyController::get( $id );
            if( empty($company) ){
                $company = CompanyController::first();
                $id = $company->co_id;
            }
        }

        $results = CompanyController::get( $id );

        if( !empty($results) ){

            // $request->session()->put('cid', $id);
            Session::put('cid', $id);
            Session::put('cname', $results->name);
            Session::put('cdomain', $results->domain);
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
            ->where('status','=',1)
            ->orderby( 'updated_at', 'desc' )
            ->first();
    }

    public static function get($id)
    {
        return DB::table('companies')
            ->where('status','=',1)
            ->where('id','=', $id)
            ->first();
    }
}
