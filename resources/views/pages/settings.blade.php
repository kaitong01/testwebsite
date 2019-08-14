@extends('index')

@section('title', 'การตั้งค่า')

@section('content')
    
    
    @component('components.columns', [
        'navleft'=> ''
    ])

        @slot('nav')
            @component('components.navleft', [
                'title' => 'การตั้งค่า',

                'current' => isset( $page_current_tab ) ? $page_current_tab: '',

                "items" => [

                    [
                        "name" => "ทัวร์",
                        "items" => [
                            ["id"=> "/settings/tours/country", "name" => "ประเทศ"],
                            ["id"=> "/settings/tours/route", "name" => "เส้นทาง"],
                            ["id"=> "/settings/tours/wholesale", "name" => "โฮลเซลล์"],
                            ["id"=> "/settings/tours/category", "name" => "ประเภททัวร์"],
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

            {{-- <ul class="datatable-checkbox nav">
                <li class="nav-item active">
                    <label class="checkbox">
                        <input type="checkbox" name="" value="" checked />
                        <span class="text">ทั้งหมด</span>
                        <span class="count">(0)</span>
                    </label>

                </li>
            </ul> --}}

        @endcomponent
        @endisset

    @endcomponent

@endsection
