<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    protected $table = 'blogs_categories';
    public $primaryKey = 'id';
    public $itemstamps = false;

    protected $fillable = [
        'name', 'description',

        'company_id', 'status',

        'seo_title', 'seo_description',
    ];
    protected $hidden = [];



    public static function status()
    {
        $status = [];
        $status[] = ['id'=> 2, 'name'=>'แบบร่าง'];
        $status[] = ['id'=> 1, 'name'=>'ใช้งาน'];
        $status[] = ['id'=> 0, 'name'=>'ระงับ'];

        return $status;
    }
}
