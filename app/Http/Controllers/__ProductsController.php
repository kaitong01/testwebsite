<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

use App\Models\Wholesale;
use App\Models\ToursSeries;
use App\Models\ToursPeriod;
use App\Models\TourWholesale;

use App\Http\Controllers\Fill_Form;


class ProductsController extends Controller
{
    private $_tabs = ['publish','draft','soldout','disable', 'yourself', 'wholesale'];

    public function index($id='publish')
    {

        // dd( Auth::user()->company->name );

        $cid = Session::get('cid');
        $filters = '';

        // $filters .= Fill_Form::wholesale_packages($cid);
        // $filters .= Fill_Form::country_packages($cid);
        // $filters .= Fill_Form::route_packages($cid);
        // $filters .= Fill_Form::category_packages($cid);
        // $filters .= Fill_Form::period($cid);
        $filters .= '<div class="filter-item search textbox-wrap">
            <input type="text" class="filter-item-input form-control form-textbox form-icon-left" id="search-input" autocomplete="off" role="combobox" name="q" value="" required="" data-action="search">
            <svg class="textbox-icon" viewBox="0 0 52.966 52.966" xmlns="http://www.w3.org/2000/svg"><path d="m51.704 51.273-14.859-15.453c3.79-3.801 6.138-9.041 6.138-14.82 0-11.58-9.42-21-21-21s-21 9.42-21 21 9.42 21 21 21c5.083 0 9.748-1.817 13.384-4.832l14.895 15.491c0.196 0.205 0.458 0.307 0.721 0.307 0.25 0 0.499-0.093 0.693-0.279 0.398-0.383 0.41-1.016 0.028-1.414zm-29.721-11.273c-10.477 0-19-8.523-19-19s8.523-19 19-19 19 8.523 19 19-8.524 19-19 19z"></path></svg>
            <button class="textbox-clear" type="button"><svg width="19" height="19" viewBox="0 0 19 19" xmlns="http://www.w3.org/2000/svg"><path d="M18.253,5.8A9.494,9.494,0,0,0,9.5,0,9.5,9.5,0,0,0,.747,5.8a9.472,9.472,0,0,0,2.035,10.41A9.526,9.526,0,0,0,5.8,18.254a9.531,9.531,0,0,0,7.394,0,9.526,9.526,0,0,0,3.022-2.043A9.5,9.5,0,0,0,18.253,5.8Zm-5.095,6.392-0.967.967L9.45,10.426,6.708,13.159l-0.967-.967L8.483,9.45,5.741,6.717l0.967-.976L9.45,8.483l2.742-2.742,0.967,0.976L10.417,9.45Z"></path></svg></button>
        </div>';


        if( in_array($id, $this->_tabs) ){

            $pageTitle = 'แพ็คเกจทัวร์ออนไลน์';

            return view('pages.products.index')->with([
                'datatable' => [
                    'title' => $pageTitle,

                    'options' => [
                        // 'page' => 1,
                        'limit' => 24
                    ],
                    "url" => '/products/show/'.$id,

                    'filter' => $filters,
                    'actions_right' => '<a class="btn btn-primary ml-2" href="/products/create"><svg class="svg-icon o__tiny o__by-text" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"><path d="M2 5v2h3v3h2V7h3V5H7V2H5v3H2z"></path></svg> <span>เพิ่มแพ็คเกจทัวร์เอง+</span></a>'
                ],
                'page_current_tab' => '/products/'.$id
            ]);

        }else{

            $data = ToursSeries::find( $id );
            if( is_null( $data ) ){
                return view('errors.404');
                // return response()->json(["message" => 'Record not found!'], 404);
            }


            $periods = ToursPeriod::where('series_id','=', $id)->orderby('start_date', 'asc')->get();

            return view('pages.products.create')->with([

                // 'wholesaleLists' => json_decode($wholesales, 1),
                'statusList' => ToursSeries::status(),
                'data' => $data,
                'periods' => $periods,
            ]);

        }


    }

    public function create()
    {

        return view('pages.products.create')->with([

            // 'wholesaleLists' => json_decode($wholesales, 1),
            'statusList' => ToursSeries::status()
        ]);
    }

    public function set_data(Request $request, $page)
    {

          $ops = array(
              'sort' => isset($request->sort)? $request->sort: 'updated_at',
              'dir' => isset($request->dir)? $request->dir: 'desc',

              'limit' => isset($request->limit)? $request->limit: 2,
              'page' => isset($request->page)? $request->page: 1,

              'ts' => time(),
          );

          ['publish','draft','soldout','disable', 'yourself', 'wholesale'];

          $sth = DB::table('tours_series')

            ->select(
                'tours_series.*'
              , 'wholesales.id as wholesale_id'
              , 'wholesales.name as wholesale_name'
            )

            ->leftJoin('wholesales','wholesales.id','=','tours_series.wholesale_id')


            ;


          $sth->where( 'tours_series.company_id', '=', Session::get('cid') );



          if($page=='publish'){
            $sth->where( 'tours_series.status', '=', 1 );
          }

          if($page=='draft'){
            $sth->where( 'tours_series.status', '=', 0 );
          }

          if($page=='disable'){
            $sth->where( 'tours_series.status', '=', 2 );
          }

          if($page=='yourself'){
            $sth->where( 'tours_series.master_id', '=', null )
            ->orWhere('tours_series.master_id', '=', 0);
          }

          if($page=='wholesale'){
            $sth->where( 'tours_series.master_id', '!=', null )
            ->where('tours_series.master_id', '!=', 0);
          }
          $toSql = $sth->toSql();

          if( isset($request->q) ){
              $ops['q'] = trim($request->q);

              $sth->Where( 'tours_series.name', 'LIKE', "%{$ops['q']}%" )
              ->orWhere('tours_series.code', 'LIKE', "%{$ops['q']}%")
              ;
          }

          if( isset($request->status) ){
              $ops['status'] = trim($request->status);
              $sth->where( 'status', '=', $ops['status'] );
          }

        //   $total = $sth;
        //   $arr['total'] = $this->count();

          $sth->orderby( $ops['sort'], $ops['dir'] );
          $sth->skip( ($ops['page']*$ops['limit'])- $ops['limit']);
          $sth->take( $ops['limit'] );



        //   $results = $sth->get();
          $results = $sth->paginate();


          $arr['options'] = $ops;
          $arr['total'] = $results->total();
          $arr['data'] = $results->items();

          $arr['items'] = $this->ui->q('ProductsUi')->init($arr['data'], $arr['options']);

          return response()->json($arr, 200);

    }
}
