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
}
