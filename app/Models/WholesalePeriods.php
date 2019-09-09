<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WholesalePeriods extends Model
{
  protected $table = 'wholesale_periods';
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
  ];
}
