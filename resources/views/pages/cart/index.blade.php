@extends('layouts.admin')

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
                            ["id"=> "/cart/waitlist", "name" => "รอตรวจสอบ"],
                            ["id"=> "/cart/published", "name" => "เผยแพร่แล้ว"],
                            ["id"=> "/cart/cancel", "name" => "ยกเลิก"],
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
