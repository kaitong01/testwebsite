<?php

namespace App\Http\Middleware;
use App\Http\Controllers\CompanyController;

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

        if( CompanyController::is() ){


            return $next($request);
        }
        else{


            return redirect('no-company');

            // return false;
            // dd('Error Page');
            // return $next($request);
        }
        


        
    }
}
