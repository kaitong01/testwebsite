<?php

namespace App\Http\Middleware;
use App\Http\Controllers\CompanyController;
use Illuminate\Support\Facades\Auth;

use Closure;

class CheckCompany
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $c = new CompanyController;

        if( Auth::user()->user_status != 1 ){
            Auth::logout();
            return redirect('/login')->with('erro_login', 'status disable');
        }
        else if( $c->is() ){
            return $response;
        }
        else{
            Auth::logout();
            return redirect('/login')->with('erro_login', 'No Company');
        }
    }
}
