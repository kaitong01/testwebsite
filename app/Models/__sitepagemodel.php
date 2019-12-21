<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sitepagemodel extends Model
{
    protected $table = 'sitepage';
    public $primatyKey = 'id';
    public $itemstamps = false;

  protected $fillable = [
    'company_id',
  ];
}
}
