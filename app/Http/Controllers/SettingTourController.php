<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CountryModel;
use App\Models\TourCountryModel;
use App\Models\TourRouteModel;
use App\Models\TourWholesaleModel;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Route;

class SettingTourController extends Controller
{

    public function index()
    {
        $tab = basename(Route::getFacadeRoot()->current()->uri);

        if( !method_exists($this, $tab) ){
            throw new AuthorizationException('You do not have permission to view this page');
        }

        return view('pages.setting.index')->with( $this->{$tab}() );
    }


    public function countries()
    {
        $filters = [];
        $filters[] = [
            'position' => 'topLeft',
            'label' => 'สถานะ',
            'type' => 'selectbox',
            'items' => array_merge([['id'=>'', 'name'=>'ทั้งหมด']], TourCountryModel::status()),
            'active' => 1,

            'name' => 'status',
            'id' => 'status',
        ];

        $filters[] = [
            'position' => 'topLeft',
            'type' => 'searchbox',

            'name' => 'q',
        ];

        return [
            'title' => 'ตั้งค่าประเทศ',
            'dis' => '',

            'datatable' => [
                'title' => 'ตั้งค่าประเทศ',

                'options' => [
                    // 'page' => 1,
                    'limit' => 24
                ],
                "url" => '/tours/countries',

                'filters' => $filters,
            ],
        ];
    }

    public function routes()
    {
        $filters = [];
        $filters[] = [
            'position' => 'topLeft',
            'label' => 'สถานะ',
            'type' => 'selectbox',
            'items' => array_merge([['id'=>'', 'name'=>'ทั้งหมด']], TourRouteModel::status()),
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
                'data-url' => '/tours/routes/create',
            ],

            'label' => '<svg class="svg-icon o__tiny o__by-text" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"><path d="M2 5v2h3v3h2V7h3V5H7V2H5v3H2z"></path></svg> <span>เพิ่มเส้นทาง</span>'
        ];

        return [
            'title' => 'ตั้งค่าเส้นทาง',
            'dis' => '',

            'datatable' => [
                'title' => 'ตั้งค่าเส้นทาง',

                'options' => [
                    // 'page' => 1,
                    'limit' => 24
                ],
                "url" => '/tours/routes',

                'filters' => $filters,
            ],
        ];
    }

    public function wholesales()
    {
        $filters = [];
        $filters[] = [
            'position' => 'topLeft',
            'label' => 'สถานะ',
            'type' => 'selectbox',
            'items' => array_merge([['id'=>'', 'name'=>'ทั้งหมด']], TourWholesaleModel::status()),
            'active' => 1,

            'name' => 'status',
            'id' => 'status',
        ];

        $filters[] = [
            'position' => 'topLeft',
            'type' => 'searchbox',

            'name' => 'q',
        ];

        return [
            'title' => 'ตั้งค่าโฮลเซลล์',
            'dis' => '',

            'datatable' => [
                'title' => 'ตั้งค่าโฮลเซลล์',

                'options' => [
                    // 'page' => 1,
                    'limit' => 24
                ],
                "url" => '/tours/wholesales',

                'filters' => $filters,
            ],
        ];
    }

    public function categories()
    {
        $filters = [];
        $filters[] = [
            'position' => 'topLeft',
            'label' => 'สถานะ',
            'type' => 'selectbox',
            'items' => array_merge([['id'=>'', 'name'=>'ทั้งหมด']], TourRouteModel::status()),
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
                'data-url' => '/tours/categories/create',
            ],

            'label' => '<svg class="svg-icon o__tiny o__by-text" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"><path d="M2 5v2h3v3h2V7h3V5H7V2H5v3H2z"></path></svg> <span>เพิ่มประเภททัวร์</span>'
        ];

        return [
            'title' => 'ตั้งค่าประเภททัวร์',
            'dis' => '',

            'datatable' => [
                'title' => 'ตั้งค่าประเภททัวร์',

                'options' => [
                    // 'page' => 1,
                    'limit' => 24
                ],
                "url" => '/tours/categories',

                'filters' => $filters,
            ],
        ];
    }
}
