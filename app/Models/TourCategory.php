<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class TourCategory extends Model
{
  protected $table = 'tour_category';
  public $primatyKey = 'id';
  public $itemstamps = false;

  protected $fillable = [
    'cid',
    'seq',
    'name',
    'start_date',
    'end_date',
    'image',
    'description',
    'status',
  ];
}
