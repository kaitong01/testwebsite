@extends('index')

@section('title', 'ลูกค้า')

@section('content')
    
    
    @component('components.columns', [

        'navleft'=> ''
    ])

        @slot('nav')
            @component('components.navleft', [
                'title' => 'แพ็คเกจทัวร์',

                "items" => [

                    [
                        "name" => "สถานะ",
                        "items" => [
                            ["id"=> "", "name" => "ทั้งหมด"],
                            ["id"=> "", "name" => "ใช้งาน"],
                            ["id"=> "", "name" => "รอการตรวจสอบ"],
                            ["id"=> "", "name" => "ระงับ"],
                        ]
                    ],
                ],
            ])

            @endcomponent

        @endslot

        @component('components.datatable', [
            'title' => 'แพ็คเกจทัวร์',

            'options' => [
                "url" => '555'
            ]
        ])

            @slot('actions_right')
                <a class="btn btn-primary ml-2" href="javascript:void(0)"><svg class="svg-icon o__tiny o__by-text" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"><path d="M2 5v2h3v3h2V7h3V5H7V2H5v3H2z"></path></svg> <span>เพิ่ม</span></a>
            @endslot

            @slot('nav')
                <ul class="page-datalist-tabs nav">
                    <li class="nav-item active"><a href="#" class="nav-link"><span class="nav-text">ทั้งหมด</span><span class="nav-count">(0)</span></a></li>
                    <li class="nav-item"><a href="#" class="nav-link"><span class="nav-text">ใช้งาน</span><span class="nav-count">(0)</span></a></li>
                    <li class="nav-item"><a href="#" class="nav-link"><span class="nav-text">รอการตรวจสอบ</span><span class="nav-count">(0)</span></a></li>
                    <li class="nav-item"><a href="#" class="nav-link"><span class="nav-text">ระงับ</span><span class="nav-count">(0)</span></a></li>

                </ul>
            @endslot

            {{-- <ul class="page-datalist-checkbox nav">
                <li class="nav-item active">
                    <label class="checkbox">
                        <input type="checkbox" name="" value="" checked />
                        <span class="text">ทั้งหมด</span>
                        <span class="count">(0)</span>
                    </label>

                </li>
            </ul> --}}

            @slot('results')

                @if ( !empty( $results ) )


                    @foreach ($results as $item)

                        <tr company-id="1686">
                            <td class="td-seq">1</td>

                            <td class="td-name active">
                                <div class="row no-gutters">

                                    <div class="col-auto" style="width: 128px"><div class="pic rounded squared"></div></div>

                                    <div class="col"><div class="pl-2">

                                        <a class="font-weight-bold text-dark" href="javascript:void(0)" data-ref="name">{{$item->co_name}}</a>

                                        <div class="layout__media ml-2">
                                            <span class="text-muted" data-ref="domain">{{$item->co_domain}}</span>
                                        </div>

                                    </div></div>

                                </div>
                            </td>


                            <td class="td-status"><div class="ui-status" style="background-color:#4CAF50">ใช้งาน</div></td>


                            <td class="td-date td-gray"><span data-ref="updated">4/06/2019 16:38</span></td>


                            <td class="td-status"><span data-ref="package_name">DEMO</span></td>


                            <td class="td-date"><span data-ref="expired"></span></td>


                            <td class="td-contact"><span data-ref="Contact"></span></td>
                        </tr>


                    @endforeach

                @endif

            @endslot



        @endcomponent

    @endcomponent

@endsection
