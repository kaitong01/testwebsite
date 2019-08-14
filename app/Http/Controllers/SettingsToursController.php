<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsToursController extends Controller
{

    private $_tabs = [

        'country' => [ 'id'=>'', 'name'=>'ประเทศ' ],
        'route' => [ 'id'=>'', 'name'=>'เส้นทาง' ],
        'wholesale' => [ 'id'=>'', 'name'=>'โฮลเซลล์' ],
        'category' => [ 'id'=>'', 'name'=>'ประเภททัวร์' ],
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( $tab=null )
    {

        // dd($this->_tabs);
        $current = null;
        foreach ($this->_tabs as $key => $value) {
            
            if( $tab==$key ){
                $current = $value;
                break;
            }
        }


        if( is_null($current) ){
            return view('pages.error');
        }


        // if( !in_array($tab, $this->_tabs) ){

        //     return view('pages.error');
        // };

        // dd($parem);

        return view('pages.settings')->with([
            'datatable' => [
                'title' => $current['name'],

                'options' => [
                    "url" => '555'
                ]
            ],
            'page_current_tab' => '/settings/tours/'.$tab
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
