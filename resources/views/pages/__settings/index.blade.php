@extends('layouts.admin')


@section('content')

    @component('components.columns', [
        'navleft'=> ''
    ])

        {{-- nav --}}
        @slot('nav')
        @component('components.navleft', [
            'title' => 'ตั้งค่า',

            'current' => Route::getFacadeRoot()->current()->uri(),

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
                        ["id"=> "/settings/blogs/categories", "name" => "ประเภทบทความ"],
                    ]
                ],
            ],
        ])






        @endcomponent
        {{-- end: endcomponent->navleft --}}
        @endslot
        {{-- end: slot->nav --}}


        {{-- component->datatable --}}
        @isset($datatable)
        @component('components.datatable', $datatable)

        @endcomponent
        @endisset
        {{-- end: component->datatable --}}



        {{-- include --}}
        @isset($include)
        @include($include)
        @endisset
        {{-- end: include --}}




    @endcomponent
    {{-- end: endcomponent->columns --}}
@endsection
