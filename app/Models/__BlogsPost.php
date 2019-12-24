<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class BlogsPost extends Model
{
  protected $table = 'blog_post';
  public $primatyKey = 'id';
  public $itemstamps = false;

  protected $fillable = [
    'cid',
    'category_id',
    'title',
    'image',
    'permalink',
    'summary',
    'text',
    'status',
    'enbaled',
    'created_uid',
    'updated_uid',
    'published',
    'exp',
    'seo_title',
    'seo_description',
    'highlight',
    'start_date',
    'end_date',
    'author',

  ];
}
