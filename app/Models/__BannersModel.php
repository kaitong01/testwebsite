<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BannersModel extends Model
{
    protected $table = 'companies_banners';
    public $primatyKey = 'id';
    public $itemstamps = false;

    protected $fillble = [
        
        'path', 'company', 'cerated_at',

    ];
}
