@extends('index')

@section('title', 'บทความ')

@section('content')


    @component('components.columns', [
        'navleft'=> ''
    ])

        @slot('nav')
            @component('components.navleft', [
                'title' => 'บทความ',

                'current' => isset( $page_current_tab ) ? $page_current_tab: '',

                "items" => [
                    [
                        "name" => "บทความ",
                        "items" => [
                            ["id"=> "/blogs/post/add", "name" => "เพิ่มบทความ"],
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

        @isset( $none )
        @include('pages.blogs.nonecategory')
        @endisset


    @endcomponent

@endsection
