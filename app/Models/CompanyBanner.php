<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyBanner extends Model
{
    protected $table = 'companies_banners';
    public $primaryKey = 'id';
    public $itemstamps = false;


    protected $fillable = [
        'path', 'caption',

        'target', 'permalink', 'theme_id', 'banner_id', 'position',
    ];
    protected $hidden = [];

}
