<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SitePage extends Model
{

    protected $table = 'site_pages';
    public $primatyKey = 'id';
    public $itemstamps = false;

    protected $fillable = [
        'name', 'content', 'description',

        'company_id', 'status', 'type', 'homepage',

        'seo_title', 'seo_description',
    ];
    protected $hidden = [];

    public static function status()
    {
        $status = [];
        $status[] = ['id'=>1, 'name'=>'ใช้งาน'];
        $status[] = ['id'=>1, 'name'=>'ระงับ'];

        return $status;
    }
}
