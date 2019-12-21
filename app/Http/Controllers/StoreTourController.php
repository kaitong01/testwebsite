<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\DatacenterSeries;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class StoreTourController extends Controller
{

    public function index(Request $request)
    {
        $tab = basename(Route::getFacadeRoot()->current()->uri);

        $tabs = [
            'tours'     => [
                'title' => 'ทั้งหมด',
            ],
            'new'       => [
                'title' => 'ทัวร์มาใหม่',
            ],
            'upcoming'  => [
                'title' => 'ใกล้วันเดินทาง',
            ],

            'discount'  => [
                'title' => 'ทัวร์ลดราคา',
            ],
            'popular'  => [
                'title' => 'ทัวร์ยอดนิยม',
            ],

            // 'selected'  => [],

        ];


        if( in_array($tab, array_keys($tabs)) ){


            $ops = $tabs[$tab];
            $ops['url'] = '/datacenter/series/'.$tab;



            // if($tab=='new'){
            //     $ops['url'] .= '/new';
            // }

            return view('pages.store.tour.index')->with( StoreTourController::_init( $request, $ops ) );
        }
        else{
            throw new AuthorizationException('You do not have permission to view this page');
        }
    }



    // set Datatable
    public static function _init ($request, $ops=[] )
    {
        return [
            'title' => 'คลัง',

            'navleft' => StoreTourController::_leftMenu($request),

            'datatable' => [
                'title' => isset($ops['title'])? $ops['title']: 'คลัง',

                'options' => [
                    'limit' => 24
                ],
                "url" => $ops['url'],

                'filters' => StoreTourController::_filters( $ops ),
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

        $wholesalesIDs = [];
        foreach (Company::wholesales( $request->user()->company->id ) as $key => $value) {
            array_push($wholesalesIDs, $value->wholesale_id);
        }


        $today = date('Y-m-d 23:59:59');
        $prevWeek = strtotime("-7 day", strtotime($today));
        $nextWeek = strtotime("+7 day", strtotime($today));


        return [
            [
                // "name" => "สถานะ",
                "items" => [
                    [
                        "id"=> "/store/tours/",
                        "name" => "ทั้งหมด",
                        'count' => DB::table('wholesale_series')->where([
                                ['status', '=', 1],
                            ])
                            ->whereIn( 'wholesale_id', $wholesalesIDs )
                            ->count()
                    ],
                    [
                        "id"=> "/store/tours/new",
                        "name" => "ทัวร์มาใหม่",
                        'count' => DB::table('wholesale_series')->where([
                                ['status', '=', 1],
                            ])
                            ->whereIn( 'wholesale_id', $wholesalesIDs )
                            ->whereBetween('created_at', [date('Y-m-d 23:59:59', $prevWeek), $today])
                            ->count()
                    ],

                    // [
                    //     "id"=> "/store/tours/upcoming",
                    //     "name" => "ใกล้วันเดินทาง",
                    //     'count' => DB::table('wholesale_series')
                    //         ->leftJoin( 'wholesale_periods', 'wholesale_periods.series_id', '=', 'wholesale_series.id' )
                    //         ->where([
                    //             ['wholesale_series.status', '=', 1],
                    //         ])

                    //         ->whereBetween('wholesale_periods.start_date', [$today, date('Y-m-d 23:59:59', $nextWeek)])

                    //         ->whereIn( 'wholesale_series.wholesale_id', $wholesalesIDs )

                    //         ->groupBy('wholesale_series.id')

                    //     ->count()
                    // ],

                    // [
                    //     "id"=> "/store/tours/discount",
                    //     "name" => "ทัวร์ลดราคา",
                    //     'count' => DB::table('wholesale_series')->where([
                    //         ['status', '=', 1],
                    //     ])->whereIn( 'wholesale_id', $wholesalesIDs )->count()
                    // ],

                    // [
                    //     "id"=> "/store/tours/popular",
                    //     "name" => "ทัวร์ยอดนิยม",
                    //     'count' => DB::table('wholesale_series')->where([
                    //         ['status', '=', 1],
                    //     ])->whereIn( 'wholesale_id', $wholesalesIDs )->count()
                    // ],
                ]
            ],
        ];
    }

}
