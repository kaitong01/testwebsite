<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    protected $table = 'blogs_posts';
    public $primaryKey = 'id';
    public $itemstamps = false;

    protected $fillable = [
        'category_id',

        'name', 'status',

        'summary', 'text',

        'seo_title', 'seo_description',
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\BlogCategory', 'category_id', 'id');
        //  \App\Models\BlogCategory::class
    }

    public static function status()
    {
        $item = [];
        $item[] = ['id'=>0, 'name'=>'ระงับ'];
        $item[] = ['id'=>1, 'name'=>'เผยแพร่'];
        $item[] = ['id'=>2, 'name'=>'แบบร่าง'];

        return $item;
    }
}
