<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Session;
use App\Models\Bookings;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $filters = '';

      $filters .= '<div class="filter-item"><label class="filter-item-label" for="status">สถานะ:</label><select class="filter-item-input form-control" id="status" name="status" data-action="change">'.
          '<option value="">All</option>'.
          '<option value="0">ใหม่</option>'.
          '<option value="1">จองแล้ว</option>'.
      '</select></div>';


      $filters .= '<div class="filter-item search textbox-wrap">
              <input type="text" class="filter-item-input form-control form-textbox form-icon-left" id="search-input" autocomplete="off" role="combobox" name="q" value="" required="" data-action="search">

              <svg class="textbox-icon" viewBox="0 0 52.966 52.966" xmlns="http://www.w3.org/2000/svg"><path d="m51.704 51.273-14.859-15.453c3.79-3.801 6.138-9.041 6.138-14.82 0-11.58-9.42-21-21-21s-21 9.42-21 21 9.42 21 21 21c5.083 0 9.748-1.817 13.384-4.832l14.895 15.491c0.196 0.205 0.458 0.307 0.721 0.307 0.25 0 0.499-0.093 0.693-0.279 0.398-0.383 0.41-1.016 0.028-1.414zm-29.721-11.273c-10.477 0-19-8.523-19-19s8.523-19 19-19 19 8.523 19 19-8.524 19-19 19z"></path></svg>

              <button class="textbox-clear" type="button"><svg width="19" height="19" viewBox="0 0 19 19" xmlns="http://www.w3.org/2000/svg"><path d="M18.253,5.8A9.494,9.494,0,0,0,9.5,0,9.5,9.5,0,0,0,.747,5.8a9.472,9.472,0,0,0,2.035,10.41A9.526,9.526,0,0,0,5.8,18.254a9.531,9.531,0,0,0,7.394,0,9.526,9.526,0,0,0,3.022-2.043A9.5,9.5,0,0,0,18.253,5.8Zm-5.095,6.392-0.967.967L9.45,10.426,6.708,13.159l-0.967-.967L8.483,9.45,5.741,6.717l0.967-.976L9.45,8.483l2.742-2.742,0.967,0.976L10.417,9.45Z"></path></svg></button>
          </div>';


      return view('pages.booking.index')->with([
          'datatable' => [
              'title' => 'การจอง',

              'options' => [
                  // 'page' => 1,
                  'limit' => 24,
                  // 'status' =>
              ],
              "url" => '/booking/datatable/show',

              'filter' => $filters,
              // 'actions_right' => '<a class="btn btn-primary ml-2" href="/booking/create"><svg class="svg-icon o__tiny o__by-text" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"><path d="M2 5v2h3v3h2V7h3V5H7V2H5v3H2z"></path></svg> <span>เพิ่มซีรีย์ทัวร์</span></a>'
          ],
      ]);
    }

    public function datatable(Request $request)
    {

      $ops = array(
          'sort' => isset($request->sort)? $request->sort: 'created_at',
          'dir' => isset($request->dir)? $request->dir: 'desc',

          'limit' => 5,
          'page' => isset($request->page)? $request->page: 1,

          'ts' => time(),
      );
      $sth = DB::table('booking')
      ->where( 'booking_company_id', '=', Session::get('cid') );

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
      // dd( $results );


      $arr['options'] = $ops;
      $arr['total'] = $results->total();
      $arr['data'] = $results->items();

      $arr['items'] = $this->ui->q('BookingTableUi')->init($arr['data'], $arr['options']);

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

    public function detail($id)
    {
      $data = DB::table('booking')
      ->join('booking_detail','booking_detail.detail_booking_id','=','booking.id')
      ->where('booking.id','=',$id)
      ->get();
      if( is_null( $data ) ){
          return response()->json(["message" => 'Record not found!'], 404);
      }

      return view('forms.booking.detail')->with('item', $data);
    }

    public function setstatus($id,$param)
    {
      if($param=="checked"){
        $booking = Bookings::find($id);
        $booking->status = 1;
        $booking->save();
      }
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
