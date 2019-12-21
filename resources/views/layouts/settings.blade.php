@extends('layouts.admin')

@section('content')

    @component('components.columns', [
        'navleft'=> ''
    ])

        @slot('nav')
        @component('components.navleft', [
            'title' => 'ตั้งค่า',

            'current' => isset( $page_current_tab ) ? $page_current_tab: '',

            "items" => [

                [
                    "name" => "ทัวร์",
                    "items" => [
                        ["id"=> "/settings/tours/countries", "name" => "ประเทศ"],
                        ["id"=> "/settings/tours/routes", "name" => "เส้นทาง"],
                        ["id"=> "/settings/tours/wholesales", "name" => "โฮลเซลล์"],
                        ["id"=> "/settings/tours/categories", "name" => "ประเภททัวร์"],
                    ]
                ],
                [
                    "name" => "บทความ",
                    "items" => [
                        ["id"=> "/settings/blogs/category", "name" => "ประเภทบทความ"],
                    ]
                ],
            ],
        ])

        @endcomponent

        @endslot

    @endcomponent
@endsection
