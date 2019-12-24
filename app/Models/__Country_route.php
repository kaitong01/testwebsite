<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Country_route extends Model
{
  protected $table = 'country_route';
  public $primatyKey = 'id';
  public $itemstamps = false;

  protected $fillable = [
    'name',
    'code_flag',
    'category_id',
    'capital',
    'status'];
}
