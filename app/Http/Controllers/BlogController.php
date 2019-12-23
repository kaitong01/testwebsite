<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $tab = basename(Route::getFacadeRoot()->current()->uri);

        $tabs = [
            'blogs' => [
                'title' => 'ทั้งหมด',
            ],
            'posted' => [
                'title' => 'เผยแพร่แล้ว',
            ],
            'scheduled' => [
                'title' => 'แบบตั้งเวลา',
            ],
            'draft' => [
                'title' => 'แบบร่าง',
            ],
            'expire' => [
                'title' => 'หมดอายุ',
            ],
            'disabled' => [
                'title' => 'ระงับ',
            ],
        ];

        if( in_array($tab, array_keys($tabs)) ){

            $ops = $tabs[$tab];
            $ops['url'] = '/blogs/find/'.$tab;

            return view('pages.blogs.index')->with( BlogController::_init( $request, $ops ) );
        }
        else{
            throw new AuthorizationException('You do not have permission to view this page');
        }
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
                            ->count()
                    ],
                ]
            ]
        ];
    }
}
