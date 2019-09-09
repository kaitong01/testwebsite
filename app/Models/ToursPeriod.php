<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToursPeriod extends Model
{
    protected $table = 'tours_periods';
    public $primatyKey = 'id';
    protected $fillable = [
      'series_id',
      'start_date',
      'end_date',
      'status',
      'created_uid',
      'updated_uid',
      'price_at',
      'prices_options',
      'company_id',


    ];
    public static function status($id='')
    {
        $status = array();
        $status[] = array('id'=>0, 'name'=> 'แบบร่าง');
        $status[] = array('id'=>1, 'name'=> 'ใช้งาน');
        $status[] = array('id'=>2, 'name'=> 'ระงับ');

        return json_decode(json_encode($status));
    }
}
