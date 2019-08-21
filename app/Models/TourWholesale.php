<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class TourWholesale extends Model
{
  protected $table = 'tour_wholesale';
  public $primatyKey = 'id';
  public $itemstamps = false;

  protected $fillable = [
    'wholesale',
    'created_uid',
    'updated_uid',
    'seq',
  ];

}
