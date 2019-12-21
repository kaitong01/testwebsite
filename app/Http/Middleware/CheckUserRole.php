<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;

class CheckUserRole
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
        if ($request->user() === null) {

            Auth::logout();
            return redirect('/login')->withErrors([
                'password' => 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง',
            ]);
        }

        if( $request->user()->status!==1 || $request->user()->role===null ){

            Auth::logout();
            return redirect('/login')->withErrors([
                'password' => 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง',
            ]);
        }


        if( $request->user()->role->id==2 &&  $request->user()->company==null ){
            Auth::logout();
            return redirect('/login')->withErrors([
                'password' => 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง',
            ]);
        }

        if( in_array($request->user()->role->id, [1,3]) ){

            $company_id = null;
            if( $request->session()->has('cid') ){
                $company_id = $request->session()->get('cid');

                // $request->session()->pull('cid', $company_id);
                // dd( $request->session()->all() );
            }

            if( $company_id ){

                $company = Company::where('status', 1)->where('id', $company_id)->first();

            }
            else{
                $company = Company::where('status', 1)->first();
            }


            $request->user()->company = $company;
        }


        if( $request->user()->company==null ){
            Auth::logout();
            return redirect('/login')->withErrors([
                'password' => 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง',
            ]);
        }


        // dd( $request->user()->company->name );
        return $next($request);
    }
}
