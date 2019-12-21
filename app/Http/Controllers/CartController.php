<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CartSerieRequest;
use App\models\Carts;
use App\Models\Company;
use App\Models\CountryModel;
use App\Models\DatacenterPeriod;
use App\Models\DatacenterSeries;
use App\Models\DefaultAirlines;
use App\Models\TourCountryModel;
use App\Models\TourPeriod;
use App\Models\TourSerie;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $tab = basename(Route::getFacadeRoot()->current()->uri);

        $tabs = [
            'carts' => [
                'title' => 'ทั้งหมด',
            ],
            'confirm' => [
                'title' => 'เผยแพร่แล้ว',
            ],
            'verify' => [
                'title' => 'รอตรวจสอบ',
            ],
            'cancel' => [
                'title' => 'ยกเลิก',
            ],
        ];

        if( in_array($tab, array_keys($tabs)) ){

            $ops = $tabs[$tab];
            $ops['url'] = '/carts/find/'.$tab;

            return view('pages.cart.index')->with( CartController::_init( $request, $ops ) );
        }
        else{
            throw new AuthorizationException('You do not have permission to view this page');
        }
    }
    public function edit (Request $request, $id)
    {
        $data = Carts::findOrFail( $id );
        $statusList = TourSerie::status();


        #
        $countryList = CountryModel::get();


        $airlineList = DefaultAirlines::get();


        $series = $data->serie;

        // $periods = $series->periods;

        $periods = DatacenterPeriod::where([
            ['series_id','=', $series->id],
        ])->orderby('start_date', 'asc')->get();

        return view('forms.cart.form', compact('data', 'statusList', 'countryList', 'airlineList', 'series', 'periods'));
    }

    public function update(CartSerieRequest $request, $id)
    {
        $cart = Carts::findOrFail( $id );


        $series = $cart->serie;
        // dd($series->gallery);


        ## clone series
        $data = TourSerie::where([
            'master_id'     => $series->id,
            'company_id'    => $request->user()->company->id,
            'wholesale_id'  => $series->wholesale_id,
        ])->first();

        if( empty($data) ){
            $data = new TourSerie;
        }

        if( $data->fill( $request->input() )->save() ){

            ## update carts
            $cart->status = 2;
            $cart->update();

            // country_id
            $hasCountry = TourCountryModel::where([
                ['country_id', '=', $series->country_id],
                ['company_id', '=', $request->user()->company->id]
            ])->count();

            if( !$hasCountry ){
                TourCountryModel::create([
                    'country_id' => $series->country_id,
                    'company_id' => $request->user()->company->id,
                ]);
            }


            ## update tourSeries
            $data->master_id = $series->id;
            $data->country_id = $series->country_id;
            $data->airline_id = $series->airline_id;
            $data->wholesale_id = $series->wholesale_id;
            $data->company_id = $request->user()->company->id;

            ## update: price_at
            $data->price_at = str_replace(',', '', $request->price_at);


            ### update: plans
            if( $request->has('plans')  ){

                $plans = [];
                foreach ($request->plans as $value) {
                    $plansTimes = [];

                    foreach ($value['items'] as $times) {
                        if( empty($times['name']) && empty($times['text']) ) continue;

                        $plansTimes[] = $times;
                    }

                    if( empty($plansTimes) && empty($value['title']) ) continue;

                    $plans[] = array(
                        'title' => trim($value['title']),
                        'items' => $plansTimes
                    );
                }
            }
            $data->plans = !empty($plans)? json_encode($plans, JSON_UNESCAPED_UNICODE): null;

            ### update: meals
            $data->meals = $request->has('meals')? json_encode($request->meals, JSON_UNESCAPED_UNICODE): null;


            ### update: hotels
            if( $request->has('hotels') ){

                $hotels = [];
                foreach ($request->hotels as $key => $value) {
                    if( empty($value['name']) ) continue;
                    $hotels[] = $value;
                }
            }
            $data->hotels = !empty($hotels)? json_encode($hotels, JSON_UNESCAPED_UNICODE): null;

            ### update: gallery
            $gallery = []; $oldGallery = json_decode($series->gallery, 1);
            if($request->has('images')){

                // dd( $request->images );
                foreach ($request->images as $img) {

                    $dataImage = array();

                    if( !empty($img['upload']) ) {
                        $dataImage['path'] = $img['upload']->store($request->user()->company->id.'/gallery/', 'public');
                        $dataImage['name'] = $img['upload']->getClientOriginalName();
                        $dataImage['size'] = $img['upload']->getClientSize();
                    }

                    if( isset($img['id']) && !empty($oldGallery) ){
                        foreach ($oldGallery as $i => $value) {
                            $img_id = isset($value['id']) ? $value['id']: $i;
                            if( $img_id==$img['id'] ){

                                $value['url'] = asset("storage/{$value['path']}"); unset( $value['path'] );
                                $dataImage = $value;
                                unset( $oldGallery[$i] );
                            }
                        }
                    }

                    if( !empty( $img['caption'] ) ){
                        $dataImage['caption'] = $img['caption'];
                    }
                    else if( isset($dataImage['caption']) ) {
                        unset($dataImage['caption']);
                    }

                    $gallery[] = $dataImage;
                }
            }

            $data->gallery = !empty($gallery)? json_encode($gallery): null;


            ### update docs
            $files = array(); $oldFiles = !empty($series->files)? json_decode($series->files, 1): [];
            if( $request->has('docs') ){

                // dd( $request->docs );
                foreach ($request->docs as $key => $value) {

                    if( !empty($value['upload']) ){
                        //insert

                        $files[] = array(
                            'name' => !empty($value['name'])? $value['name']: $value['upload']->getClientOriginalName(),
                            'exten' => $value['upload']->getClientOriginalExtension(),
                            'size' => $value['upload']->getClientSize(),
                            'key' => $value['key'],
                            'path' => $value['upload']->store($request->user()->company->id.'/docs/', 'public'),
                        );

                    } else if( !empty($value['name']) && !empty($oldFiles) ){

                        // update
                        foreach ($oldFiles as $val) {
                            if( $val['key']==$value['key'] ){
                                $val['name'] = $value['name'];

                                $val['url'] = asset("storage/{$val['path']}"); unset( $val['path'] );
                                $files[] = $val;
                            }
                        }
                    }
                }
            }
            $data->files = !empty($files)? json_encode($files): null;


            ## update permalink
            $permalink = $request->has('permalink')
                ? $this->fn->q('text')->createPermalink($request->permalink)
                : $this->fn->q('text')->createPermalink($request->name);

            $count = TourSerie::where([
                ['permalink', '=', $permalink],
                ['company_id', '=', $request->user()->company->id],
            ])->count();

            if( $count>0 ){
                $permalink += "-".($count+1);
            }
            $data->permalink = $permalink;

            ## all update
            $data->created_uid = $request->user()->id;
            $data->updated_uid = $request->user()->id;
            $data->update();


            ### set: period
            foreach ($request->period as $item) {

                if( empty($item['start_date']) || empty($item['end_date']) ) continue;

                $period = new TourPeriod();

                // $period->wholesale_id = $request->wholesale_id;
                $period->series_id = $data->id;

                list($d, $m, $y) = explode('/', $item['start_date']);
                $period->start_date = date("{$y}-{$m}-{$d}");

                list($d, $m, $y) = explode('/', $item['end_date']);
                $period->end_date = date("{$y}-{$m}-{$d}");

                $period->status = $item['status'];

                $prices = array();
                if( !empty($item['prices_options']) ){
                    foreach ($item['prices_options'] as $price) {
                        $prices[] = str_replace(',', '', $price);
                    }
                }

                if( !empty( $prices[0] ) ){
                    $period->price_at = $prices[0];
                }

                $period->prices_options = !empty($prices)? json_encode($prices): '';
                // $period->discount = $item['discount'];
                $period->created_uid = $request->user()->id;
                $period->updated_uid = $request->user()->id;

                $period->save();
            }

            // $res['data'] = $data;
            $res['code'] = 200;
            $res['message'] = 'บันทึกข้อมูลแล้ว';

            $res['call'] = 'refreshDatatable';
            // $res['redirect'] = "/tours/series/{$data->id}/edit";
        }
        else{

            $res['code'] = 402;
            $res['message'] = 'บันทึกข้อมูลล้มเหลว, กรุณาลองใหม่';
        }

        return response()->json($res, $res['code']);
    }

    public function switch(Request $request)
    {

        if( $request->has('id') ){
            $data = Carts::findOrFail( $request->id );
        }
        else{
            $data = new Carts();
        }


        if( $data->fill( $request->input() )->save() ){

            $data->cid = $request->user()->company->id;
            $data->update();

            $res['data'] = $data;
            $res['code'] = 200;
            $res['message'] = 'บันทึกข้อมูลแล้ว';
        }
        else{
            $res['code'] = 402;
            $res['message'] = 'บันทึกข้อมูลล้มเหลว, กรุณาลองใหม่';
        }

        return response()->json($res, $res['code']);

    }

    public function delete($id)
    {
        $data = Carts::findOrFail( $id );

        $series = $data->serie;

        return view('forms.cart.delete', compact('data', 'series'));
    }
    public function destroy($id)
    {
        $data = Carts::findOrFail( $id );

        $data->status = 0;
        $data->update();

        return response()->json([
            "message" => 'ยกเลิกข้อมูลเรียบร้อย',
            'code' => 200,
            'info' => 'Successfully',

            // 'delete' => '[blog-category-id='.$id.']',
            'call' => 'refreshDatatable',

        ], 200);
    }

    // get data
    public function find(Request $request, $tab='')
    {
        $ops = [
            'sort' => isset($request->sort)? $request->sort: 'wholesale_series.updated_at',
            'dir' => isset($request->dir)? $request->dir: 'desc',

            'limit' => isset($request->limit)? $request->limit: 1,
            'page' => isset($request->page)? $request->page: 1,

            'ts' =>  isset($request->ts)? $request->ts: time(),
        ];

        $where = [];

        // if( $request->has('status') ){
        //
        // }

        if( $tab=='confirm' ){
            $where[] = ['carts.status', '=', 2];
        }

        if( $tab=='verify' ){
            $where[] = ['carts.status', '=', 1];
        }

        if( $tab=='cancel' ){
            $where[] = ['carts.status', '=', 0];
        }



        if( $request->has('q') ){
            $where[] = ['name', 'LIKE', "%{$request->q}%"];
            $ops['q'] = $request->q;
        }

        $where[] = ['wholesale_series.status', '=', 1];
        $wholesalesIDs = Company::wholesalesIds( $request->user()->company->id );

        $sth = DatacenterSeries::where($where)
            ->join( 'carts', 'carts.wh_series_id', '=', 'wholesale_series.id' );


        $sth
            ->whereIn( 'wholesale_series.wholesale_id', $wholesalesIDs )

            ->orderby( $ops['sort'], $ops['dir'] )

            ->skip( ($ops['page']*$ops['limit'])-$ops['limit'])
            ->take( $ops['limit'] );

        $results = $sth->paginate( $ops['limit'] );

        $res = [
            'options' => $ops,
            'total' => $results->total(),
            'data' => $results->items(),
        ];

        $res['code'] = 200;
        $res['info'] = 'Results successfully';
        $res['message'] = 'The request has succeeded.';

        // dd($res);
        $res['items'] = $this->ui->item('CartDatatable')->init( $res['data'], $ops );

        return response()->json($res, 200);
    }

    // set Datatable
    public static function _init ($request, $ops=[] )
    {
        return [
            'title' => '',

            'navleft' => CartController::_leftMenu($request),

            'datatable' => [
                'title' => isset($ops['title'])? $ops['title']: 'ตะกร้า',

                'options' => [
                    'limit' => 24
                ],
                "url" => $ops['url'],

                'filters' => CartController::_filters( $ops ),
            ],
        ];
    }
    public static function _filters( $ops=[] )
    {

        $ops = array_merge( [
            'status' => 1,
            'state' => '',
        ], $ops );


        $filters = [];

        $filters[] = [
            'position' => 'topLeft',
            'type' => 'searchbox',

            'name' => 'q',
        ];


        return $filters;
    }
    public static function _leftMenu($request)
    {

        $wholesalesIDs = Company::wholesalesIds( $request->user()->company->id );

        $today = date('Y-m-d 23:59:59');
        $prevWeek = strtotime("-7 day", strtotime($today));
        $nextWeek = strtotime("+7 day", strtotime($today));

        return [
            [
                // "name" => "สถานะ",
                "items" => [
                    [
                        "id"=> "/carts",
                        "name" => "ทั้งหมด",
                        'count' => DB::table('wholesale_series')
                            ->join('carts', 'carts.wh_series_id', '=', 'wholesale_series.id')
                            // ->where([])
                            ->whereIn( 'wholesale_series.wholesale_id', $wholesalesIDs )
                            ->count()
                    ],
                    [
                        "id"=> "/carts/confirm",
                        "name" => "เผยแพร่แล้ว",
                        'count' => DB::table('wholesale_series')

                            ->join('carts', 'carts.wh_series_id', '=', 'wholesale_series.id')
                            ->where([
                                ['carts.status', '=', 2],
                            ])
                            ->whereIn( 'wholesale_series.wholesale_id', $wholesalesIDs )
                            ->count()
                    ],
                    [
                        "id"=> "/carts/verify",
                        "name" => "รอตรวจสอบ",
                        'count' => DB::table('wholesale_series')

                            ->join('carts', 'carts.wh_series_id', '=', 'wholesale_series.id')
                            ->where([
                                ['carts.status', '=', 1],
                            ])
                            ->whereIn( 'wholesale_series.wholesale_id', $wholesalesIDs )
                            ->count()
                    ],


                ]
            ],

            [
                "items" => [
                    [
                        "id"=> "/carts/cancel",
                        "name" => "ยกเลิก",
                        'count' => DB::table('wholesale_series')

                            ->join('carts', 'carts.wh_series_id', '=', 'wholesale_series.id')
                            ->where([
                                ['carts.status', '=', 0],
                            ])
                            ->whereIn( 'wholesale_series.wholesale_id', $wholesalesIDs )
                            ->count()
                    ],
                ]
            ]
        ];
    }
}
