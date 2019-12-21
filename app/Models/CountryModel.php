<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CountryModel extends Model
{

    protected $table = 'countries';
    public $primaryKey = 'id';
    public $itemstamps = false;


    public function region(){
        return $this->belongsTo('App\Models\RegionModel');
    }


    public function routes()
    {
        return $this->belongsToMany('App\Models\TourRouteModel', 'tours_routes_countries', 'country_id', 'route_id');
    }
}
