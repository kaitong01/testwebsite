<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class SiteController extends Controller
{
  private $_tabs = ['infomation','home','themecolor','fonts', 'slideshow', 'banners','picture','google_analytic', 'google_adwords', 'onweb', 'wholesale'];
    // public function menu(Request $request)
    // {
    // 	// return is_null($method) ? $this->getRoutes() : Arr::get($this->routes, $method, []);
    // 	$is = is_null($request->is_open) ? 0: $request->is_open;
    // 	// $menuOpen = Session::get('site_menu_open');

    // 	Session::put('site_menu_open', $is);
    // 	return response()->json(['success'=>'Got Simple Ajax Request.', 'site_menu_open'=>$is]);
    // }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index( $tab='infomation' )
     {

       if( !in_array($tab, $this->_tabs) ){
         dd($tab);
           return view('pages.error');
       }else{
         return view('pages.site.index')->with([
             'page' => $tab,
             'page_current_tab' => '/site/webeditor/'.$tab
         ]);
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

        // return is_null($method) ? $this->getRoutes() : Arr::get($this->routes, $method, []);

        if($request->has('is_menu_open')){

            $is = is_null($request->is_menu_open) ? 0: $request->is_menu_open;
            Session::put('site_menu_open', $is);
        }
    	// $menuOpen = Session::get('site_menu_open');

    	return response()->json(['success'=>'Got Simple Ajax Request.'], 200);
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
