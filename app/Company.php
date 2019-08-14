<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Company extends Model
{
    protected $table = 'companies';
    public $primatyKey = 'co_id';
    public $itemstamps = false;

    protected $fillable = [
    	  'co_name'
    	, 'co_username'
    	, 'co_domain'
    ];


    public function get($id)
    {
        return DB::table('companies')
            ->where('co_status','=',1)
            ->where('co_id','=', $id)
            ->first();
    }
}
