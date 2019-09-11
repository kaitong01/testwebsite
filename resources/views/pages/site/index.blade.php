@extends('layouts.admin')

@section('title', 'แพ็คเกจทัวร์')

@section('content')

    @component('components.columns', [
        'navleft'=> ''
    ])

        @slot('nav')
            @component('components.navleft', [
                'title' => 'Website Editor',

                'current' => isset( $page_current_tab ) ? $page_current_tab: '',

                "items" => [

                    [

                        "items" => [
                            ["id"=> "/site/webeditor/home", "name" => "หน้าเว็บไซต์"],
                            ["id"=> "/site/webeditor/themecolor", "name" => "สีเว็ปไซต์"],
                            ["id"=> "/site/webeditor/fonts", "name" => "ฟอนต์เว็บไซต์"],
                            ["id"=> "/site/webeditor/slideshow", "name" => "Slideshow"],
                            ["id"=> "/site/webeditor/banners", "name" => "Banners"],
                            ["id"=> "/site/webeditor/picture", "name" => "Picture Size (Package Tour)"],
                            ["id"=> "/site/webeditor/onweb", "name" => "การแสดงผลของเว็บไซต์"],
                            ["id"=> "/site/webeditor/wholesale", "name" => "การเลือกโปรแกรมจากโฮลเซลล์"],

                        ]
                    ],
                ],
            ])

            @endcomponent

        @endslot


        @isset( $page )
        @if($page=='home')
        @include('pages.site.webeditor.home')
        @elseif($page=='themecolor')
        @include('pages.site.webeditor.themecolor')
        @elseif($page=='fonts')

        @elseif($page=='slideshow')

        @elseif($page=='banners')

        @elseif($page=='picture')

        @elseif($page=='onweb')

        @elseif($page=='wholesale')

        @endif
        @endisset

    @endcomponent

@endsection
