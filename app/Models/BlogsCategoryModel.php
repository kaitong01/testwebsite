<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogsCategoryModel extends Model
{
    protected $table = 'blog_category';
    public $primatyKey = 'id';
    public $itemstamps = false;

    protected $fillable = ['name', 'description'];

}
