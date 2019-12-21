@extends('layouts.admin')

@section('title', 'คลังแพคเกจทัวร์')

@section('content')

<div style="background: linear-gradient(135deg,#e4e6f5,#ecf6ff 39%,#ddecff);background-size: 100% 302px;background-repeat: no-repeat;    padding-bottom: 56px;">
        <div class="business-settings-container" style="margin-left: auto;margin-right: auto">

            <div class="business-settings-header" style="background: transparent">

                <div class="d-flex">
                    <div>
                        <h1 class="title">คลังแพคเกจทัวร์</h1>
                        {{-- <p class="sub-title">เพิ่มแพคเกจทัวร์จากโฮลเซลล์</p> --}}
                    </div>

                </div>

                <form action="/store/find" method="get" class="row row-sm mt-2">
                    {{-- <div class="filter-item"><label for="status" class="filter-item-label">โฮลเซลล์:</label><select id="status" name="status" data-action="change" class="filter-item-input form-control"><option value="">ทั้งหมด</option><option value="1">ใช้งาน</option><option value="2">ระงับ</option></select></div> --}}

                    <div class="col">
                        <input type="text" autocomplete="off" role="combobox" name="q" class="form-control" placeholder="ค้นหา...">
                    </div>

                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">ค้นหา</button>
                    </div>
                </form>
            </div>


            <div class="business-settings-body">

                <div class="store-product pt-3">

                    @include('pages.store.sections.carousel-featured')


                    @if (!empty($periodLastWeek['data']))
                    <div class="store-product-section" data-plugin="storeProductGrid" data-options="{{ json_encode([
                        'url' => '/api/v1/store/products',
                        'options' => [
                            'limit' => 3,
                            'sort' => 'periodLastWeek',
                            // 'company_id' => $company_id,

                            'itemStyle' => 3
                        ]
                    ]) }}">

                    <div class="store-product-section-header d-flex justify-content-between align-items-center">
                        <div class="store-product-section-header-title">
                            <h3>เดินทางในอาทิตย์นี้</h3>
                        </div>

                        <div><a href="/store/tours/upcoming"><span class="mr-1">ดูทั้งหมด</span><i class="fa fa-angle-right"></i></a></div>
                    </div>
                    <div class="store-product-section-body">

                        @component('components.product-grid', [
                            'items' => $periodInWeek['data'],
                            'itemStyle' => 3
                        ])

                        @endcomponent
                        </div>
                    </div>
                    @endif
                    {{-- end: periodLastWeek --}}



                    @if (!empty($pecent['data']))
                    <div class="store-product-section">

                        <div class="store-product-section-header d-flex justify-content-between align-items-center">
                            <div class="store-product-section-header-title">
                                <h3>ทัวร์มาใหม่</h3>
                            </div>

                            <div><a href="/store/tours/new?sort=created_at&dir=desc"><span class="mr-1">ดูทั้งหมด</span><i class="fa fa-angle-right"></i></a></div>
                        </div>
                        <div class="store-product-section-body">
                            @component('components.product-grid', [
                                'items' => $pecent['data']
                            ])

                            @endcomponent
                        </div>
                    </div>
                    @endif
                    {{-- end: pecent --}}


                    @if (!empty($discount['data']))
                    <div class="store-product-section">

                        <div class="store-product-section-header d-flex justify-content-between align-items-center">
                            <div class="store-product-section-header-title">
                                <h3>ทัวร์ไฟไหม้</h3>
                            </div>

                            <div><a href="/store/tours/discount"><span class="mr-1">ดูทั้งหมด</span><i class="fa fa-angle-right"></i></a></div>
                        </div>
                        <div class="store-product-section-body">
                            @component('components.product-grid', [
                                'items' => $discount['data']
                            ])

                            @endcomponent
                        </div>
                    </div>
                    @endif
                    {{-- end: discount --}}



                    @if (!empty($popular['data']))
                    <div class="store-product-section">

                        <div class="store-product-section-header  d-flex justify-content-between align-items-center">
                            <div class="store-product-section-header-title">
                                <h3>ทัวร์ยอดนิยม</h3>
                            </div>

                            <div><a href="/store/tours/popular"><span class="mr-1">ดูทั้งหมด</span><i class="fa fa-angle-right"></i></a></div>
                        </div>
                        <div class="store-product-section-body">
                            @component('components.product-grid', [
                                'items' => $popular['data']
                            ])

                            @endcomponent
                        </div>
                    </div>
                    @endif
                    {{-- end: popular --}}


                    @isset($wholesales)
                    <div class="store-product-section">

                        <div class="store-product-section-header d-flex justify-content-between align-items-center">
                            <div class="store-product-section-header-title">
                                <h3>โฮลเซลล์</h3>
                            </div>

                            <div><a href="/tours/wholesale"><span class="mr-1">เลือกโฮลเซลล์</span><i class="fa fa-angle-right"></i></a></div>
                        </div>
                        <div class="store-product-section-body">
                            <div class="products-grid">
                                <?php

                                $arr = ['https://probookingcenter.com/public/images/logo/128x128.png', 'https://www.bestindochina.com/img/logo.svg', 'http://www.ttntour.com/www_ttntour/image/logo_ttntour.png'];


                                foreach ($whole_all as $row) {


                                        $src = $arr[rand(0,2)];
                                        $img = !empty( $row->logo )? '<img src="'.asset("storage/{$row->logo}").'" alt="">': '';
                                    ?>
                                <div class="product-item six-column" style="">


                                    <a href="/store/wholesale/{{$row->id}}" class="product-item-pic pic" style="border-radius: 50%">{{$img}}</a>

                                    <div class="product-item-body text-center">

                                        <h3 class="product-item-title y-ellipsis clamp-2" style="overflow: hidden;text-overflow: ellipsis;white-space: nowrap;"><a title="{{$row->name}}" href="/store/wholesale/{{$row->id}}" style="overflow: hidden; overflow-wrap: break-word;"><span class="product-item-code">{{$row->name}}</span></a></h3>

                                    </div>


                                </div>
                                <?php } ?>

                            </div>
                        </div>
                    </div>
                    @endisset
                    {{-- end: wholesales --}}



                    <div class="store-product-section brand-once d-none" style="background: #00113d">

                        <div class="store-product-section-header d-flex justify-content-between align-items-center">
                            <div class="store-product-section-header-title">
                                <h3></h3>
                            </div>

                            <div><a href="/store/wholesale/1"><span class="mr-1">ดูทั้งหมด</span><i class="fa fa-angle-right"></i></a></div>
                        </div>


                        <div class="store-product-section-body">


                            <div class="row">
                                <div class="col-auto" style="width:156px">
                                    <div class="store-product-section-brand">
                                        <div class="pl-2">
                                        <h2 class="mb-2">Pro Booking Center</h2>
                                        <a  href="/store/wholesale/1" class="btn btn-sm btn-outline-light"><span class="mr-2">ดูเพิ่ม</span><i class="fa fa-angle-right"></i></a>
                                    </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="products-grid horizontal">
                                        <?php for ($i=0; $i < 6; $i++) { ?>
                                        <div class="product-item">
                                            <div class="product-item-pic pic">
                                                <img src="https://probookingcenter.com/public/upload/travel/img_1_2019_08_09_11_0_33.jpg" alt="วินาทีสุดท้าย Feat. น้ำ Aliz - Single">
                                            </div>
                                            <div class="product-item-body">
                                                <h3 class="product-item-title"><a title="วินาทีสุดท้าย Feat. น้ำ Aliz - Single" class="" href="/store/tours/1" style="overflow: hidden; overflow-wrap: break-word;">วินาทีสุดท้าย Feat. น้ำ Aliz - Single</a></h3>

                                                <span class="product-item-sub d-none-brand-once"><span><a href="/store/wholesale/1">The Drive</a></span></span>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    {{--  --}}


                    <div class="store-product-section brand-once  d-none" style="background: rgb(232, 41, 41);">

                        <div class="store-product-section-header d-flex justify-content-between align-items-center">
                            <div class="store-product-section-header-title">
                                <h3></h3>
                            </div>

                            <div><a href="/store/wholesale/2"><span class="mr-1">ดูทั้งหมด</span><i class="fa fa-angle-right"></i></a></div>
                        </div>


                        <div class="store-product-section-body">


                            <div class="row">
                                <div class="col-auto" style="width:156px">
                                    <div class="store-product-section-brand">
                                        <div class="pl-2">
                                        <h2 class="mb-2">Best Indochina Travel</h2>
                                        <a  href="/store/wholesale/1" class="btn btn-sm btn-outline-light"><span class="mr-2">ดูเพิ่ม</span><i class="fa fa-angle-right"></i></a>
                                    </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="products-grid horizontal">
                                        <?php for ($i=0; $i < 6; $i++) { ?>
                                        <div class="product-item">
                                            <div class="product-item-pic pic">
                                                <img src="https://probookingcenter.com/public/upload/travel/img_1_2019_08_09_11_0_33.jpg" alt="วินาทีสุดท้าย Feat. น้ำ Aliz - Single">
                                            </div>
                                            <div class="product-item-body">
                                                <h3 class="product-item-title"><a title="วินาทีสุดท้าย Feat. น้ำ Aliz - Single" class="" href="/store/tours/1" style="overflow: hidden; overflow-wrap: break-word;">วินาทีสุดท้าย Feat. น้ำ Aliz - Single</a></h3>

                                                <span class="product-item-sub d-none-brand-once"><span><a href="/store/wholesale/1">The Drive</a></span></span>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    {{--  --}}

                </div>
                {{-- end: store-product --}}

            </div>
        </div>
</div>


@endsection
