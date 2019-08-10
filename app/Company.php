<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'companies';
    public $primatyKey = 'co_id';
    public $itemstamps = false;

    protected $fillable = [
    	  'co_name'
    	, 'co_username'
    	, 'co_domain'
    ];
}
