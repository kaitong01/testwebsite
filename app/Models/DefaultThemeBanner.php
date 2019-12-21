<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DefaultThemeBanner extends Model
{
    protected $table = 'defaults_themes_banners';
    public $primatyKey = 'id';
    public $itemstamps = false;


    public static function target()
    {
        $item = [];
        $item[] = ['id'=>0, 'name'=>'_parent'];
        $item[] = ['id'=>1, 'name'=>'_blank'];

        return $item;
    }
}
