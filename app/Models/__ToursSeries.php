<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToursSeries extends Model
{
    protected $table = 'tours_series';
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
      'master_id',
      'whole_code',
      'company_id',


    ];
    public static function status($id='')
    {
        $status = array();
        $status[] = array('id'=>0, 'name'=> 'แบบร่าง');
        $status[] = array('id'=>1, 'name'=> 'เผยแพร่');
        $status[] = array('id'=>2, 'name'=> 'ระงับ');

        return json_decode(json_encode($status));
    }
}
