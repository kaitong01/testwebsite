<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TourSerie extends Model
{

    protected $table = 'tours_series';
    public $primaryKey = 'id';
    public $itemstamps = false;

    protected $fillable = [
        'status',

        'country_id', 'route_id', 'airline_id',

        'name', 'code',
        'days', 'nights', 'description',

        'meals_note', 'hotels_note', 'periods_note',

        'conditions',

        'airline_custom',

        'seo_title', 'seo_description',
    ];
    protected $hidden = [];

    public function wholesale(){
        return $this->belongsTo('App\Models\Wholesale');
    }
    public function periods()
    {
        return $this->belongsToMany('App\Models\TourPeriod', 'series_id')->withPivot('start_date');
    }

    public static function status()
    {
        $status = [];
        $status[] = ['id'=> 2, 'name'=>'แบบร่าง'];
        $status[] = ['id'=> 1, 'name'=>'เผยแพร่'];
        $status[] = ['id'=> 0, 'name'=>'ระงับ'];

        return $status;
    }

    public static function state()
    {
        $status = [];
        $status[] = ['id'=> 1, 'name'=>'สร้างเอง'];
        $status[] = ['id'=> 2, 'name'=>'จากโฮลเซลล์'];

        return $status;
    }



    public static function _filters( $ops=array() )
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

        $filters[] = [
            'position' => 'bottomLeft',
            'label' => 'สถานะ',
            'type' => 'selectbox',
            'items' => array_merge([['id'=>'', 'name'=>'ทั้งหมด']], TourSerie::status()),
            'active' => $ops['status'],

            'name' => 'status',
            'id' => 'status',
        ];


        $filters[] = [
            'position' => 'bottomLeft',
            'label' => 'รายการ',
            'type' => 'selectbox',
            'items' => array_merge([['id'=>'', 'name'=>'ทั้งหมด']], TourSerie::state()),
            'active' => $ops['state'],

            'name' => 'state',
            'id' => 'state',
        ];


        $filters[] = [
            'position' => 'topRight',
            'type' => 'link',

            'style' => 'primary',

            'url' => '/tours/series/create',

            'label' => '<svg class="svg-icon o__tiny o__by-text" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"><path d="M2 5v2h3v3h2V7h3V5H7V2H5v3H2z"></path></svg> <span>เพิ่มทัวร์</span>'
        ];


        return $filters;
    }

    public static function _leftMenu()
    {


        $wholesalesIDs = Company::wholesalesIds( Auth::user()->company->id );


        $wholesalesIDsAddCustom = $wholesalesIDs;
        array_push($wholesalesIDsAddCustom, 0);

        return [
            [
                "name" => "สถานะ",
                "items" => [
                    [
                        "id"=> "/products/publish",
                        "name" => "เผยแพร่",
                        'count' => DB::table('tours_series')
                            ->where([
                                ['company_id', Auth::user()->company->id],
                                ['status', 1],
                            ])
                            ->whereIn( 'wholesale_id', $wholesalesIDsAddCustom )
                            ->count()
                    ],
                    [
                        "id"=> "/products/draft",
                        "name" => "แบบร่าง",
                        'count' => DB::table('tours_series')
                            ->where([
                                ['company_id', Auth::user()->company->id],
                                ['status', 2],
                            ])
                            ->whereIn( 'wholesale_id', $wholesalesIDsAddCustom )
                            ->count()
                    ],
                    [
                        "id"=> "/products/disable",
                        "name" => "ระงับ",
                        'count' => DB::table('tours_series')
                            ->where([
                                ['company_id', Auth::user()->company->id],
                                ['status', 0],
                            ])
                            ->whereIn( 'wholesale_id', $wholesalesIDsAddCustom )
                            ->count()
                    ],
                ]
            ],
            [
                "name" => "รายการสร้าง",
                "items" => [
                    [
                        "id"=> "/products/yourself",
                        "name" => "สร้างเอง",
                        'count' => DB::table('tours_series')->where([
                            ['company_id', Auth::user()->company->id],
                            ['wholesale_id', 0],
                        ])->count()
                    ],
                    [
                        "id"=> "/products/wholesale",
                        "name" => "จากโฮลเซลล์",
                        'count' => DB::table('tours_series')->where([
                            ['company_id', Auth::user()->company->id],

                        ])
                        ->whereIn( 'wholesale_id', $wholesalesIDsAddCustom )
                        ->count()
                    ],
                ]
            ],
        ];
    }


    public static function _init( $ops=[] )
    {
        return [
            'title' => 'ซีรี่ย์ทัวร์',

            'navleft' => TourSerie::_leftMenu(),

            'datatable' => [
                'title' => 'ซีรี่ย์ทัวร์',

                'options' => [
                    // 'page' => 1,
                    'limit' => 24
                ],
                "url" => '/tours/series',

                'filters' => TourSerie::_filters( $ops ),
            ],
        ];
    }
}
