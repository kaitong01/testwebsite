@extends('layouts.admin')

@section('title', 'แพ็คเกจทัวร์')

@section('content')

    @component('components.columns', [
        'navleft'=> ''
    ])

        @slot('nav')
            @component('components.navleft', [
                'title' => 'แพ็คเกจทัวร์',

                'current' => isset( $page_current_tab ) ? $page_current_tab: '',

                "items" => [

                    [
                        "name" => "สถานะ",
                        "items" => [
                            ["id"=> "/products/publish", "name" => "เผยแพร่"],
                            ["id"=> "/products/draft", "name" => "แบบร่าง"],
                            ["id"=> "/products/soldout", "name" => "หมดพีเรียด"],
                            ["id"=> "/products/disable", "name" => "ระงับ"],
                        ]
                    ],
                    [
                        "name" => "โปรแกรมทัวร์",
                        "items" => [
                            ["id"=> "/products/yourself", "name" => "สร้างเอง"],
                            ["id"=> "/products/wholesale", "name" => "จากโฮลเซลล์"],
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

    @endcomponent

@endsection
