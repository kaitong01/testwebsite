<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($tab='')
    {

        return view('pages.store.index')->with([
            'page_current_tab' => '/settings/blogs/'.$tab
        ]);
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


            return view('pages.store.detail');
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
