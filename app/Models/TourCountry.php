<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class TourCountry extends Model
{
  protected $table = 'tour_country';
  public $primatyKey = 'id';
  public $itemstamps = false;

  protected $fillable = [
    'country',
    'created_uid',
    'updated_uid'
  ];

}
