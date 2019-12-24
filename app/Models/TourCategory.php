<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class TourCategory extends Model
{
  protected $table = 'tours_categories';
  public $primatyKey = 'id';
  public $itemstamps = false;

  protected $fillable = [
    'company_id',

    'name', 'description',

    'seo_title', 'seo_description',

    'seq', 'status',
  ];
}
