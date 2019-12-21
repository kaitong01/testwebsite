<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Carts;
use App\Models\WholesaleSeries;
use App\Models\WholesalePeriods;
use App\Models\ToursSeries;
use App\Models\ToursPeriod;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    protected $table = 'carts';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($tab='waitlist')
    {
        $filters = '';



        // $filters .= '<div class="filter-item"><label class="filter-item-label" for="status">สถานะ:</label><select class="filter-item-input form-control" id="status" name="status" data-action="change">'.
        //     '<option value="">ทั้งหมด</option>'.
        //     '<option value="1">ใช้งาน</option>'.
        //     '<option value="2">ระงับ</option>'.
        // '</select></div>';


        $filters .= '<div class="filter-item search textbox-wrap">
                <input type="text" class="filter-item-input form-control form-textbox form-icon-left" id="search-input" autocomplete="off" role="combobox" name="q" value="" required="" data-action="search">

                <svg class="textbox-icon" viewBox="0 0 52.966 52.966" xmlns="http://www.w3.org/2000/svg"><path d="m51.704 51.273-14.859-15.453c3.79-3.801 6.138-9.041 6.138-14.82 0-11.58-9.42-21-21-21s-21 9.42-21 21 9.42 21 21 21c5.083 0 9.748-1.817 13.384-4.832l14.895 15.491c0.196 0.205 0.458 0.307 0.721 0.307 0.25 0 0.499-0.093 0.693-0.279 0.398-0.383 0.41-1.016 0.028-1.414zm-29.721-11.273c-10.477 0-19-8.523-19-19s8.523-19 19-19 19 8.523 19 19-8.524 19-19 19z"></path></svg>

                <button class="textbox-clear" type="button"><svg width="19" height="19" viewBox="0 0 19 19" xmlns="http://www.w3.org/2000/svg"><path d="M18.253,5.8A9.494,9.494,0,0,0,9.5,0,9.5,9.5,0,0,0,.747,5.8a9.472,9.472,0,0,0,2.035,10.41A9.526,9.526,0,0,0,5.8,18.254a9.531,9.531,0,0,0,7.394,0,9.526,9.526,0,0,0,3.022-2.043A9.5,9.5,0,0,0,18.253,5.8Zm-5.095,6.392-0.967.967L9.45,10.426,6.708,13.159l-0.967-.967L8.483,9.45,5.741,6.717l0.967-.976L9.45,8.483l2.742-2.742,0.967,0.976L10.417,9.45Z"></path></svg></button>

            </div>';


        return view('pages.cart.index')->with([
            'datatable' => [
                'title' => 'นำเข้าข้อมูล',

                'options' => [
                    // 'page' => 1,
                    'limit' => 24
                ],
                "url" => "/cart/datatable/".$tab,

                'filter' => $filters,
                'actions_right' => '<a class="btn btn-primary ml-2" href="/store"><svg class="svg-icon o__tiny o__by-text" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"><path d="M2 5v2h3v3h2V7h3V5H7V2H5v3H2z"></path></svg> <span>ค้นหาแพคเกจทัวร์</span></a>'
            ],
            'page_current_tab' => '/cart/'.$tab
        ]);
    }
    public function find(Request $request)
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


        // $total = $sth;
        // $arr['total'] = $total->count();


        $sth->orderby( $ops['sort'], $ops['dir'] );
        $sth->skip( ($ops['page']*$ops['limit'])- $ops['limit']);
        $sth->take( $ops['limit'] );

        $results = $sth->paginate($ops['limit']);

        $arr['options'] = $ops;
        $arr['total'] = $results->total();
        $arr['data'] = $results->items();

        $arr['items'] = $this->ui->q('BlogCategoryUi')->init($arr['data'], $arr['options']);

        return response()->json($arr, 200);
    }


    public function datatable(Request $request, $type)
    {

      $ops = array(
          'sort' => isset($request->sort)? $request->sort: 'wholesale_series.created_at',
          'dir' => isset($request->dir)? $request->dir: 'desc',

          'limit' => 5,
          'page' => isset($request->page)? $request->page: 1,

          'ts' => time(),
      );


      $sth = DB::table('wholesale_series')
      ->join('carts','carts.wh_series_id','=','wholesale_series.id');
      $sth->where( 'cid', '=', Session::get('cid') );
      if($type=='waitlist'){
        $sth->where( 'carts.status', '=', 1 );
      }
      if($type=='published'){
        $sth->where( 'carts.status', '=', 2 );
      }
      if($type=='cancel'){
        $sth->where( 'carts.status', '=', 0 );
      }


      if( isset($request->q) ){
          $ops['q'] = trim($request->q);

          $sth->where( 'name', 'LIKE', "%{$ops['q']}%" );
      }

      if( isset($request->status) ){
          $ops['status'] = trim($request->status);
          $sth->where( 'status', '=', $ops['status'] );
      }


      $sth->orderby( $ops['sort'], $ops['dir'] );
      $sth->skip( ($ops['page']*$ops['limit'])- $ops['limit']);
      $sth->take( $ops['limit'] );

      $results = $sth->paginate($ops['limit']);


      $arr['options'] = $ops;
      $arr['total'] = $results->total();
      $arr['data'] = $results->items();

      $arr['items'] = $this->ui->q('CartTableUi')->init($arr['data'], $arr['options']);

      return response()->json($arr, 200);
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
    public function cancel($id)
    {
      $db_cart = DB::table('carts')
      ->where('cid','=',Session::get('cid'))
      ->where('wh_series_id','=',$id)
      ->first();

      if($db_cart!=null){
        $cart = Carts::find($db_cart->id);
        $cart->status = 0;
        $cart->save();
      }else{
          return redirect()->back();
      }
      return redirect()->back();
    }
    public function published($id)
    {

      $tour_series = ToursSeries::where('master_id','=',$id)
      ->where('company_id','=',Session::get('cid'))
      ->first();

      if(!empty($tour_series)){
          return redirect()->back();
      }else{

          $wh_series =  WholesaleSeries::find($id);
          $wh_period =  WholesalePeriods::where('series_id','=',$id)->orderBy('start_date','asc')->get();

          if(!empty($wh_series)){

            $tour_series = new ToursSeries;
            $tour_series->wholesale_id   =  $wh_series->wholesale_id;
            $tour_series->master_id   =  $wh_series->id;
            $tour_series->country_id   =  $wh_series->country_id;
            $tour_series->airline_id   =  $wh_series->airline_id;
            $tour_series->code   =  $wh_series->code;
            $tour_series->name   =  $wh_series->name;
            $tour_series->highlight   =  $wh_series->highlight;
            $tour_series->description   =  $wh_series->description;
            $tour_series->status   =  1;
            $tour_series->days   =  $wh_series->days;
            $tour_series->nights   =  $wh_series->nights;
            $tour_series->price_at   =  $wh_series->price_at;
            $tour_series->airline   =  $wh_series->airline;
            $tour_series->plans   =  $wh_series->plans;
            $tour_series->meals   =  $wh_series->meals;
            $tour_series->meals_note   =  $wh_series->meals_note;
            $tour_series->hotels   =  $wh_series->hotels;
            $tour_series->hotels_note   =  $wh_series->hotels_note;
            $tour_series->conditions   =  $wh_series->conditions;
            $tour_series->files   =  $wh_series->files;
            $tour_series->gallery   =  $wh_series->gallery;
            $tour_series->periods_note   =  $wh_series->periods_note;
            $tour_series->created_uid   =  '';
            $tour_series->updated_uid   =  '';
            $tour_series->whole_code   =  $wh_series->whole_code;
            $tour_series->company_id   =  Session::get('cid');

            if($tour_series->save()){
              $db_cart = DB::table('carts')
              ->where('cid','=',Session::get('cid'))
              ->where('wh_series_id','=',$id)
              ->first();

              if($db_cart!=null){
                $cart = Carts::find($db_cart->id);
                $cart->status = 2;
                $cart->save();
              }
              if(!empty($wh_period)){
                foreach ($wh_period as $row) {
                  $tour_period = new ToursPeriod;
                  $tour_period->series_id = $tour_series->id;
                  $tour_period->start_date = $row->start_date;
                  $tour_period->end_date = $row->end_date;
                  $tour_period->status = $row->status;
                  $tour_period->created_uid = '';
                  $tour_period->updated_uid = '';
                  $tour_period->price_at = $row->price_at;
                  $tour_period->prices_options = $row->prices_options;
                  $tour_period->company_id = Session::get('cid');
                  $tour_period->save();
                }
                $arr['code'] = 200;
                $arr['message'] = 'บันทึกเรียบร้อย';
                // $arr['redirect'] = 'refresh';

                $arr['call'] = 'refreshDatatable';
              }else{
                $arr['code'] = 422;
                $arr['message'] = 'บันทึกข้อมูลล้มเหล่ว, กรุณาลองใหม่';
              }

            }else{
              $arr['code'] = 422;
              $arr['message'] = 'บันทึกข้อมูลล้มเหล่ว, กรุณาลองใหม่';
            }

          }else{
            $arr['code'] = 422;
            $arr['message'] = 'บันทึกข้อมูลล้มเหล่ว, กรุณาลองใหม่';
          }

      }


        //return response()->json($arr, $arr['code']);
        return redirect()->back();
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
