@extends('index')

@section('title', 'ตะกร้า')

@section('content')


    @component('components.columns', [
        'navleft'=> ''
    ])

        @slot('nav')
            @component('components.navleft', [
                'title' => 'ตะกร้า',

                'current' => isset( $page_current_tab ) ? $page_current_tab: '',

                "items" => [

                    [
                        "name" => "ทัวร์",
                        "items" => [
                            ["id"=> "/cart/series", "name" => "ซีรีย์ทัวร์"],
                            // ["id"=> "/cart/imported", "name" => "นำเข้าแล้ว"],
                            // ["id"=> "/settings/tours/wholesale", "name" => "โฮลเซลล์"],
                            // ["id"=> "/settings/tours/category", "name" => "ประเภททัวร์"],
                        ]
                    ],

                ],
            ])

            @endcomponent

        @endslot


        @isset( $datatable )
        @component('components.datatable', $datatable)

            @isset( $datatable->actions_right )
            @slot('actions_right')
                $datatable->actions_right
            @endslot
            @endisset


            @isset( $datatable->tabs )
                @slot('nav')
                $datatable->tabs
                @endslot
            @endisset


        @endcomponent
        @endisset


        @isset( $se )
        Hello
        @endisset


    @endcomponent

@endsection
