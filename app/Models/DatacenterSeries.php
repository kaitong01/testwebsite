<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DatacenterSeries extends Model
{
    protected $table = 'wholesale_series';
    public $primatyKey = 'id';
    public $itemstamps = false;

    public function periods()
    {
        return $this->belongsToMany('App\Models\DatacenterPeriod', 'wholesale_periods', 'id', 'series_id');
    }

    public function wholesale(){
        return $this->belongsTo('App\Models\Wholesale');
    }

    # convert: Data
    public static function buildFrag($results, $ops=[]) {
        $data = [];
        foreach ($results as $item) {
            if( empty($item) ) continue;
            $data[] = DatacenterSeries::convert( $item, $ops );
        }
        return $data;
    }
    public static function convert($data, $ops=[]){

        $data->cart = DB::table('carts')->where([
            ['wh_series_id', '=', $data->id ],
            ['cid', '=', Auth::user()->company->id ],

        ])->first();


        // $permalink = strtolower($data->name);
        // $data->permalink = asset('/tours/countries/'.$permalink);

        // $data->name = ucwords($permalink);

        return $data;
    }
}
