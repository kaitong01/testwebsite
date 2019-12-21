<?php

namespace App\Http\Controllers;

use App\Models\CompanyBanner;
use App\Models\CompanySlide;
use App\Models\DefaultFont;
use App\Models\DefaultThemeBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\SitePage;
use App\Models\SitePageDefault;


class SiteController extends Controller
{

    private $navleft = [
        [
            "name" => "การตั้งค่า",
            "items" => [
                ["id"=> "/site/menus", "name" => "เมนู"],
                ["id"=> "/site/fonts", "name" => "ฟอนต์"],
                ["id"=> "/site/colors", "name" => "สี"],
            ]
        ],
        [
            "name" => "การตั้งค่าขั้นสูง",
            "items" => [
                ["id"=> "/site/slides", "name" => "ภาพสไลด์"],
                ["id"=> "/site/banners", "name" => "แบนเนอร์"],
            ]
        ]
    ];

     public function index( $tab='menus' )
     {

        $data = [];

        ## tab: menus
        if( $tab=='menus'){
            $data['items'] = SitePage::where( 'company_id', '=', Auth::user()->company->id )->orderBy('seq', 'asc')->get();
            $data['defaults'] = SitePageDefault::orderBy('seq', 'asc')->get();
        }

        ## tab: fonts
        if($tab=='fonts'){
            $data['items'] = DefaultFont::get();
            $data['active'] = Auth::user()->company->font_id;
        }

        ## tab: slides
        if($tab=='slides'){
            $slides = CompanySlide::where( 'company_id', '=', Auth::user()->company->id )->get();

            $data = [];
            foreach ($slides as $item) {
                $data[] = [
                    'id' => $item->id,
                    'src' => asset( "storage/{$item->path}" ),
                    'caption' => $item->caption,
                    'permalink' => $item->permalink,
                    'title' => $item->title,
                ];
            }
        }


        ## tab: banners
        if($tab=='banners'){
            $data['banners'] = DefaultThemeBanner::where( 'theme_id', '=', Auth::user()->company->theme_id )->orderby( 'position', 'asc' )->get();
            $data['target'] = DefaultThemeBanner::target();


            foreach ($data['banners']as $key => $value) {

                $item = CompanyBanner::where([

                    ['banner_id', '=', $value['id']],
                    ['company_id', '=', Auth::user()->company->id],

                ])->first();


                $data['banners'][$key]['item'] = $item;
            }
        }


        return view('pages.site.index')->with([
            'navleftItems' => $this->navleft,
            'navleftItemsCurrentTab' => '/site/'.$tab,

            'inc' => "tabs.{$tab}",

            'data' => $data,
        ]);

    }


}
