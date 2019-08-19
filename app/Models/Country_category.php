<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Country_category extends Model
{
  protected $table = 'country_category';
  public $primatyKey = 'id';
  public $itemstamps = false;

  protected $fillable = [
    'name',
    'status'];
}
