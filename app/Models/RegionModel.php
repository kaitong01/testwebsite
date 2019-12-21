<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegionModel extends Model
{
    protected $table = 'countries_regions';
    public $primaryKey = 'id';
    public $itemstamps = false;


    protected $fillable = [
        'name', 'description'
    ];

    public function country(){
        return $this->hasMany('App\Models\CountryModel');
    }


}
