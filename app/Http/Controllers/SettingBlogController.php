<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Route;

class SettingBlogController extends Controller
{

    public function index()
    {
        $tab = basename(Route::getFacadeRoot()->current()->uri);

        if( !method_exists($this, $tab) ){
            throw new AuthorizationException('You do not have permission to view this page');
        }

        return view('pages.setting.index')->with( $this->{$tab}() );
    }

    public function categories()
    {
        $filters = [];
        $filters[] = [
            'position' => 'topLeft',
            'label' => 'สถานะ',
            'type' => 'selectbox',
            'items' => array_merge([['id'=>'', 'name'=>'ทั้งหมด']], BlogCategory::status()),
            'active' => 1,

            'name' => 'status',
            'id' => 'status',
        ];

        $filters[] = [
            'position' => 'topLeft',
            'type' => 'searchbox',

            'name' => 'q',
        ];

        $filters[] = [
            'position' => 'topRight',
            'type' => 'button',

            'style' => 'primary',

            'attr' => [
                'data-plugin' => "lightbox",
                'data-url' => '/blogs/categories/create',
            ],

            'label' => '<svg class="svg-icon o__tiny o__by-text" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"><path d="M2 5v2h3v3h2V7h3V5H7V2H5v3H2z"></path></svg> <span>เพิ่มประเภทบทความ</span>'
        ];

        return [
            'title' => 'ตั้งค่าประเภทบทความ',
            'dis' => '',

            'datatable' => [
                'title' => 'ตั้งค่าประเภทบทความ',

                'options' => [
                    // 'page' => 1,
                    'limit' => 24
                ],
                "url" => '/blogs/categories',

                'filters' => $filters,
            ],


        ];
    }
}
