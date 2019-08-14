<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Library\Business;

class SettingsBlogsController extends Controller
{

    private $_tabs = array('category');
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( $tab=null )
    {

        if( !in_array($tab, $this->_tabs) ){

            return view('pages.error');
        };


        return view('pages.settings')->with([
            'datatable' => [
                'title' => 'ประเภทบทความ',

                'options' => [
                    'page' => 1,
                    'limit' => 24
                ],
                "url" => '/blogs/category',

                'actions_right' => '<a class="btn btn-primary ml-2" href="/blogs/category/add" data-plugin="lightbox"><svg class="svg-icon o__tiny o__by-text" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"><path d="M2 5v2h3v3h2V7h3V5H7V2H5v3H2z"></path></svg> <span>เพิ่ม</span></a>'
            ],
            'page_current_tab' => '/settings/blogs/'.$tab
        ]);
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
