<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'articles';
    public $primatyKey = 'id';
    public $itemstamps = false;

    protected $fillable = ['title', 'body'];
}
