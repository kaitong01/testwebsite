<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WholesaleSeries extends Model
{
    //
    protected $table = 'wholesale_series';
    public $primatyKey = 'id';


    protected $fillable = [
      'wholesale_id',
      'country_id',
      'airline_id',
      'code',
      'name',
      'highlight',
      'description',
      'status',
      'days',
      'nights',
      'price_at',
      'airline',
      'plans',
      'meals',
      'meals_note',
      'hotels',
      'hotels_note',
      'conditions',
      'files',
      'gallery',
      'periods_note',
      'created_uid',
      'updated_uid',

    ];



    public static function periodLastWeek($ops=array())
    {
        $ops = array_merge( array(
            'periodLastWeek'=>true,
        ), $ops );

        return self::get( $ops );
    }
    public static function get($ops=array())
    {
        $ops = array_merge( array(
            'limit' => 50,
            'page' => 1,

            'sort' => 'updated_at',
            'dir' => 'desc',

        ), $ops );
        // dd($ops);

        $fields = 'wholesale_series.*';
        $table = 'wholesale_series';
        $sth = DB::table($table);
        $sth->select( $fields );


        $sth->leftJoin('wholesales', 'wholesales.id', '=', 'wholesale_series.wholesale_id');
        $sth->selectRaw("wholesales.id as wholesale_id,wholesales.name as wholesale_name");

        $sth->selectRaw("CONCAT( wholesale_series.days, ' วัน ',wholesale_series.nights, ' คืน' ) AS plan_days");


        $sth->leftJoin('wholesale_periods', 'wholesale_periods.series_id', '=', 'wholesale_series.id');
        $sth->selectRaw("GROUP_CONCAT( IF(wholesale_periods.start_date > NOW(), wholesale_periods.start_date, NULL) ) as period_start");
        $sth->selectRaw("GROUP_CONCAT( IF(wholesale_periods.start_date > NOW(), wholesale_periods.end_date, NULL) ) as period_end");
        $sth->selectRaw("GROUP_CONCAT( IF(wholesale_periods.start_date > NOW(), wholesale_periods.price_at, NULL) ) as period_price");

        // $sth->selectRaw("CONCAT( wholesale_series.days, ' วัน ',wholesale_series.nights, ' คืน' ) AS plan_days");

        // ->leftJoin('posts', 'users.id', '=', 'posts.user_id')

        // $conditions = self::__setConditions( $ops );


        // $sql = trim("SELECT {$fields} FROM {$table} {$conditions['where']}");
        // dd($sql);

        if( !empty( $ops['wholesale'] ) ){
            if ( is_array($ops['wholesale']) ){
                $sth->whereIn( 'wholesale_id', implode(',', array_values($ops['wholesale'])) );
            }
            else{
                $sth->where( 'wholesale_id', '=', $ops['wholesale'] );
            }
        }elseif( !empty( $ops['wholesales'] ) ){
            if ( is_array($ops['wholesales']) ){
                $sth->whereIn( 'wholesale_id', implode(',', array_values($ops['wholesales'])) );
            }
        }

        if( isset($ops['q']) ){

            $sth->Where( 'wholesale_series.name', 'LIKE', "%{$ops['q']}%" )
            ->orWhere('wholesale_series.code', 'LIKE', "%{$ops['q']}%")
            ;
        }


        if( isset($ops['periodLastWeek']) ){
            $sth->where( 'wholesale_periods.start_date', '>=', 'NOW()' );
            $sth->orderby( 'wholesale_periods.start_date', 'desc' );
        }
        else{
            $sth->orderby( 'wholesale_series.'. $ops['sort'], $ops['dir'] );
        }

        if(isset($ops['between'])){
          $start_date = $ops['between'][0];
          $end_date = $ops['between'][1];
          $sth->whereBetween('wholesale_periods.start_date', [$start_date, $end_date]);
        }


        $sth->groupBy('wholesale_series.id');


        // $sth->skip( ($ops['page']*$ops['limit'])- $ops['limit']);
        // $sth->take( $ops['limit'] );
        $results = $sth->paginate( $ops['limit'] );

        // dd($results);
        return [
            'total' => $results->total(),
            'data' => $results->items(),
            'options' => $ops,
            'sql' => $sth->toSql()
        ];

    }

    public static function once( $id )
    {

        $fields = 'wholesale_series.*';
        $table = 'wholesale_series';
        $sth = DB::table($table);
        $sth->select( $fields );

        $sth->leftJoin('wholesales', 'wholesales.id', '=', 'wholesale_series.wholesale_id');
        $sth->selectRaw("wholesales.id as wholesale_id,wholesales.name as wholesale_name");

        $sth->selectRaw("CONCAT( wholesale_series.days, ' วัน ',wholesale_series.nights, ' คืน' ) AS plan_days");


        $sth->leftJoin('wholesale_periods', 'wholesale_periods.series_id', '=', 'wholesale_series.id');
        $sth->selectRaw("GROUP_CONCAT( IF(wholesale_periods.start_date > NOW(), wholesale_periods.start_date, NULL) ) as period_start");
        $sth->selectRaw("GROUP_CONCAT( IF(wholesale_periods.start_date > NOW(), wholesale_periods.end_date, NULL) ) as period_end");
        $sth->selectRaw("GROUP_CONCAT( IF(wholesale_periods.start_date > NOW(), wholesale_periods.price_at, NULL) ) as period_price");


        $sth->where( 'wholesale_series.id', '=', $id );

        $sth->groupBy('wholesale_series.id');

        return $sth->first();
    }
}
