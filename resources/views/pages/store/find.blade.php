@extends('layouts.admin')

@section('title', 'คลังแพคเกจทัวร์')

@section('content')

<div style="background: linear-gradient(135deg,#e4e6f5,#ecf6ff 39%,#ddecff);background-size: 100% 302px;background-repeat: no-repeat;    padding-bottom: 56px;">
        <div class="business-settings-container" style="margin-left: auto;margin-right: auto">

        <div class="business-settings-header" style="background: transparent">

                <div class="d-flex">
                    <div>
                        <h1 class="title">คลังแพคเกจทัวร์</h1>
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

                        <div class="store-product-section">

                            <div class="store-product-section-header d-flex justify-content-between align-items-center">

                                <nav class="bread-crumps">
                                    <ul>
                                        <li><a href="/store">คลังแพคเกจทัวร์</a></li>
                                        <li>ค้นหา</li>
                                    </ul>
                                </nav>


                            </div>

                            <div class="store-product-section-body">
                                <div class="products-grid">
                                    <?php for ($i=0; $i < 12; $i++) { ?>
                                    <div class="product-item" style="">
                                        <div class="item-card">
                                            <a class="product-item-pic pic" href="/store/tours/1">
                                                <img src="https://image.joox.com/JOOXcover/0/8e68029d712eb83e/640" alt="วินาทีสุดท้าย Feat. น้ำ Aliz - Single">
                                            </a>
                                            <div class="product-item-body">
                                                <span class="product-item-code">TDD59-149103</span>
                                                <h3 class="product-item-title"><a title="วินาทีสุดท้าย Feat. น้ำ Aliz - Single" class="jsx-2087142158" href="/store/tours/1" style="overflow: hidden; overflow-wrap: break-word;">วินาทีสุดท้าย Feat. น้ำ Aliz - Single</a></h3>

                                                <div class="product-item-price"><?=number_format( 19999 )?></div>
                                                <span class="product-item-sub"><span><a href="/store/tours/1">by Pro Booking Center</a></span></span>

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
                    </div>
            </div>
        </div>
</div>



@endsection
