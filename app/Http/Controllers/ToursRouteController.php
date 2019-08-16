<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

use DB;
use App\Library\Fn;

use App\Library\Form;

use App\Models\ToursRoute;

class ToursRouteController extends Controller
{
    protected $table = 'tour_route';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $ops = array(
          'sort' => isset($request->sort)? $request->sort: 'updated_at',
          'dir' => isset($request->dir)? $request->dir: 'desc',

          'limit' => isset($request->limit)? $request->limit: 2,
          'page' => isset($request->page)? $request->page: 1,

          'ts' => time(),
      );


      $sth = DB::table($this->table);
      $sth->where( 'cid', '=', Session::get('cid') );


      if( isset($request->q) ){
          $ops['q'] = trim($request->q);

          $sth->where( 'name', 'LIKE', "%{$ops['q']}%" );
      }

      if( isset($request->status) ){
          $ops['status'] = trim($request->status);
          $sth->where( 'status', '=', $ops['status'] );
      }


      $total = $sth;

      $sth->orderby( $ops['sort'], $ops['dir'] );
      $sth->skip( ($ops['page']*$ops['limit'])- $ops['limit']);
      $sth->take( $ops['limit'] );


      $results = $sth->get();
      $arr['total'] = $total->count();

      $arr['data'] = $results;
      $arr['options'] = $ops;

      $arr['items'] = $this->ui->req('Item_TourRoute')->init($arr['data'], $arr['options']);

      return response()->json($arr, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('forms.tours.route.add');
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
