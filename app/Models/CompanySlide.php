<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanySlide extends Model
{

    protected $table = 'companies_slides';
    public $primaryKey = 'id';
    public $itemstamps = false;


    protected $fillable = [
        'title', 'caption',

        'path', 'permalink', 'original_name',
    ];
    protected $hidden = [];
}
