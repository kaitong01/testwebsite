<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Carts extends Model
{
    protected $table = 'carts';
    public $primatyKey = 'id';
    public $itemstamps = false;

    protected $fillable = [
        'cid',
        'wh_series_id',
        'status',
    ];

    public function serie()
    {
        return $this->belongsTo('App\Models\DatacenterSeries', 'wh_series_id'); // foreign_key, other_key
    }
}
