<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slideshowmodel extends Model
{
    protected $table = 'companies_slide';
  public $primatyKey = 'id';
  public $itemstamps = false;

  protected $fillable = [
    'file',
    'company_id',
    'created_uid',
  ];
}
