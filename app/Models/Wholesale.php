<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wholesale extends Model
{

    protected $table = 'wholesales';
    public $primatyKey = 'id';
    public $itemstamps = false;


    public function TourSerie(){
        return $this->hasMany('App\Models\TourSerie');
    }

    public function companies()
    {
        return $this->belongsToMany('App\Models\Company', 'companies_wholesales_permit', 'company_id', 'wholesale_id');
    }
}
