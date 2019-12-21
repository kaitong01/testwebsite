<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Company extends Model
{
    protected $table = 'companies';
    public $primatyKey = 'id';
    public $itemstamps = false;

    protected $fillable = [
        'name', 'description',

        'font_id',
    ];

    public function user(){
        return $this->hasMany('App\User');
    }


    public function buildFrag($results, $options=array()) {
        $data = array();
        foreach ($results as $key => $value) { if( empty($value) ) continue; $data[] = $this->convert( $value ); }
        return $data;
    }

    public function convert($data){
        // $data = $this->__prefixField($this->_prefixTable, $data);

        return $data;
    }

    public static function wholesales( $id )
    {
        return DB::table('companies_wholesales_permit')->where([
            ['company_id', '=', $id],
            ['status', '=', 1]
        ])->get();
    }


    public static function wholesalesIds( $id )
    {
        $ids = [];
        foreach (Company::wholesales( $id ) as $item) {
            array_push($ids, $item->wholesale_id);
        }

        return $ids;

    }




}
