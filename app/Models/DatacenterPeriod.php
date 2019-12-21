<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DatacenterPeriod extends Model
{
    protected $table = 'wholesale_periods';
    public $primatyKey = 'id';

    public function serie()
    {
        return $this->hasMany('App\Models\DatacenterSeries');
    }
}
