@extends('index')

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
                        <input type="text" autocomplete="off" role="combobox" name="q" class="form-control" placeholder="ค้าหา...">
                    </div>

                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">ค้นหา</button>
                    </div>
                </form>
            </div>



            <div class="business-settings-body">

                    <div class="store-product pt-3">
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class=""></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="1" class="active"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="2" class=""></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item">
                                <img src="http://localhost/img/store/programe.jpg" alt="" >
                            </div>
                            <div class="carousel-item active">

                                <img src="http://localhost/img/store/design.jpg" alt="" >

                            </div>
                            <div class="carousel-item">
                                <img src="http://localhost/img/store/web.jpg" alt="" >
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                        </div>

                        <div class="store-product-section">

                            <div class="store-product-section-header d-flex justify-content-between align-items-center">
                                <div class="store-product-section-header-title">
                                    <h3>เดินทางในอาทิตย์นี้</h3>
                                </div>

                                <div><a href="/store/tours/upcoming"><span class="mr-1">ดูทั้งหมด</span><i class="fa fa-angle-right"></i></a></div>
                            </div>
                            <div class="store-product-section-body">
                                <div class="products-grid">
                                    <?php for ($i=0; $i < 3; $i++) { ?>
                                    <div class="product-item three-column" style="">

                                        <div class="item-card ">
                                            <div class="row no-gutters">
                                                <div class="col-4">
                                                    <a href="/store/tours/1" class="product-item-pic pic" style="border-radius: 0.25rem 0 0 0.25rem;">
                                                        <img src="https://probookingcenter.com/public/upload/travel/img_1_2019_08_09_11_0_33.jpg" alt="วินาทีสุดท้าย Feat. น้ำ Aliz - Single">
                                                    </a>
                                                </div>
                                                <div class="col-8">
                                                    <div class="product-item-body pl-2 layout__box o__has-rows h-100">


                                                            <h3 class="product-item-title y-ellipsis clamp-2 layout__box" style="overflow: hidden;text-overflow: ellipsis;white-space: nowrap;"><a title="วินาทีสุดท้าย Feat. น้ำ Aliz - Single" class="" href="/store/tours/1" style="overflow: hidden; overflow-wrap: break-word;"><span class="product-item-code">TDD59-149103</span> - <span>ดานัง-เว้-ฮอยอัน-บานาฮิลล์ 4วัน พักบานาฮิล</span></a></h3>

                                                            <div class="layout__box o__flexes-to-1">
                                                                <table class="product-item-table product-detail-meta">
                                                                    <tbody>
                                                                        <?php for ($k=1; $k <= 2; $k++) { ?>
                                                                        <tr>
                                                                            <td class="td-index"><?=$k?>.</td>
                                                                            <td class="td-date">24 - 27 ส.ค.</td>
                                                                            <td class="td-price">19,999</td>
                                                                        </tr>
                                                                        <?php } ?>
                                                                    </tbody>
                                                                </table>

                                                            </div>

                                                            <div class="product-item-sub layout__box"><span><a href="/store/wholesale/1">Pro Booking Center</a></span></div>

                                                        {{-- <div class="product-item-actions">
                                                            <button class="btn btn-primary btn-block btn-sm">เผยแพร่</button>
                                                        </div> --}}

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>


                        <div class="store-product-section">

                            <div class="store-product-section-header d-flex justify-content-between align-items-center">
                                <div class="store-product-section-header-title">
                                    <h3>ทัวร์มาใหม่</h3>
                                </div>

                                <div><a href="/store/tours/new"><span class="mr-1">ดูทั้งหมด</span><i class="fa fa-angle-right"></i></a></div>
                            </div>
                            <div class="store-product-section-body">
                                <div class="products-grid">
                                    <?php for ($i=0; $i < 12; $i++) { ?>
                                    <div class="product-item" style="">
                                        <div class="item-card">
                                            <div class="product-item-pic pic">
                                                <img src="https://probookingcenter.com/public/upload/travel/img_1_2019_08_09_11_0_33.jpg" alt="วินาทีสุดท้าย Feat. น้ำ Aliz - Single">
                                            </div>
                                            <div class="product-item-body">
                                                <span class="product-item-code">TDD59-149103</span>
                                                <h3 class="product-item-title"><a title="วินาทีสุดท้าย Feat. น้ำ Aliz - Single" class="" href="/store/tours/1" style="overflow: hidden; overflow-wrap: break-word;">วินาทีสุดท้าย Feat. น้ำ Aliz - Single</a></h3>

                                                <div class="product-item-price"><?=number_format( 19999 )?></div>
                                                <span class="product-item-sub"><span><a href="/store/wholesale/1">Pro Booking Center</a></span></span>

                                                <div class="product-item-actions">
                                                    <button class="btn btn-primary btn-block btn-sm">เผยแพร่</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                        <div class="store-product-section">

                            <div class="store-product-section-header d-flex justify-content-between align-items-center">
                                <div class="store-product-section-header-title">
                                    <h3>ทัวร์ไฟไหม้</h3>
                                </div>

                                <div><a href="/store/tours/discount"><span class="mr-1">ดูทั้งหมด</span><i class="fa fa-angle-right"></i></a></div>
                            </div>
                            <div class="store-product-section-body">
                                <div class="products-grid">
                                    <?php for ($i=0; $i < 6; $i++) { ?>
                                    <div class="product-item">
                                        <div class="product-item-pic pic">
                                            <img src="https://probookingcenter.com/public/upload/travel/img_1_2019_08_09_11_0_33.jpg" alt="วินาทีสุดท้าย Feat. น้ำ Aliz - Single">
                                        </div>
                                        <div class="product-item-body">
                                            <h3 class="product-item-title"><a title="วินาทีสุดท้าย Feat. น้ำ Aliz - Single" class="" href="/store/tours/1" style="overflow: hidden; overflow-wrap: break-word;">วินาทีสุดท้าย Feat. น้ำ Aliz - Single</a></h3>

                                            <span class="product-item-sub"><span><a href="/store/wholesale/1">The Drive</a></span></span>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>






                        <div class="store-product-section">

                            <div class="store-product-section-header  d-flex justify-content-between align-items-center">
                                <div class="store-product-section-header-title">
                                    <h3>ทัวร์ยอดนิยม</h3>
                                </div>

                                <div><a href="/store/tours/popular"><span class="mr-1">ดูทั้งหมด</span><i class="fa fa-angle-right"></i></a></div>
                            </div>
                            <div class="store-product-section-body">
                                <div class="products-grid">
                                    <?php for ($i=0; $i < 6; $i++) { ?>
                                    <div class="product-item">
                                        <div class="product-item-pic pic">
                                            <img src="https://probookingcenter.com/public/upload/travel/img_1_2019_08_09_11_0_33.jpg" alt="วินาทีสุดท้าย Feat. น้ำ Aliz - Single">
                                        </div>
                                        <div class="product-item-body">
                                            <h3 class="product-item-title"><a title="วินาทีสุดท้าย Feat. น้ำ Aliz - Single" class="" href="/store/tours/1" style="overflow: hidden; overflow-wrap: break-word;">วินาทีสุดท้าย Feat. น้ำ Aliz - Single</a></h3>

                                            <span class="product-item-sub"><span><a href="/store/wholesale/1">The Drive</a></span></span>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>


                        <div class="store-product-section">

                            <div class="store-product-section-header d-flex justify-content-between align-items-center">
                                <div class="store-product-section-header-title">
                                    <h3>โฮลเซลล์</h3>
                                </div>

                                <div><a href="/store/wholesales"><span class="mr-1">ดูทั้งหมด</span><i class="fa fa-angle-right"></i></a></div>
                            </div>
                            <div class="store-product-section-body">
                                <div class="products-grid">
                                    <?php

                                    $arr = ['https://probookingcenter.com/public/images/logo/128x128.png', 'https://www.bestindochina.com/img/logo.svg', 'http://www.ttntour.com/www_ttntour/image/logo_ttntour.png'];
                                    for ($i=0; $i < 12; $i++) {

                                            // $src = $i%2
                                            //     ? ''
                                            //     : '';


                                            $src = $arr[rand(0,2)];

                                        ?>
                                    <div class="product-item six-column" style="">


                                        <a href="/store/tours/1" class="product-item-pic pic" style="border-radius: 50%">
                                            <img src="<?=$src?>" alt="วินาทีสุดท้าย Feat. น้ำ Aliz - Single">
                                        </a>

                                        <div class="product-item-body text-center">


                                            <h3 class="product-item-title y-ellipsis clamp-2" style="overflow: hidden;text-overflow: ellipsis;white-space: nowrap;"><a title="" class="" href="/store/wholesale/1" style="overflow: hidden; overflow-wrap: break-word;"><span class="product-item-code">Pro Booking Center</span></a></h3>


                                        </div>


                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                        <div class="store-product-section brand-once" style="background: #00113d">

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


                            <div class="store-product-section brand-once" style="background: rgb(232, 41, 41);">

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



                            </div>

            </div>
        </div>
</div>



@endsection
