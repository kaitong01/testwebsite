@extends('layouts.admin')

@section('title', 'คลังแพคเกจทัวร์')

@section('content')

<?php


$Fn = new Fn;

$decode_files = $Fn->q('decode')->DbjsonToObject($data->files);

$tr_period = $Fn->q('trperiod')->set_tr($period);

?>

<div style="background: linear-gradient(135deg,#e4e6f5,#ecf6ff 39%,#ddecff);background-size: 100% 302px;background-repeat: no-repeat;    padding-bottom: 56px;">
        <div class="business-settings-container" style="margin-left: auto;margin-right: auto">


            <div class="business-settings-body">

                <div class="store-product pt-3">

                    <div class="store-product-section">

                        <div class="store-product-section-header d-flex justify-content-between align-items-center">

                            <nav class="bread-crumps">
                                <ul>
                                    <li><a href="/store"><i class="fa fa-home mr-1"></i><span>คลังแพคเกจทัวร์</span></a></li>
                                    <li><a href="/store/wholesale/{{$data->wholesale_id}}">{{$data->wholesale_name}}</a></li>

                                    @if ( !empty($data->country_id) )
                                    <li><a href="/store/wholesale/{{$data->wholesale_id}}/country/{{$data->country_id}}">{{$Fn->q('trperiod')->country_name($data->country_id)}}</a></li>
                                    @endif
                                    <li>{{$data->name}}</li>
                                </ul>
                            </nav>


                        </div>

                        <div class="store-product-section-body">
                            <div class="row">
                                <div class="col-3">
                                    <div class="product-detail-pic pic mb-3" style="padding-top: 100%">
                                        {{ Fn::getGalleryCoverElem( $data->gallery ) }}
                                    </div>

                                    <table class="product-detail-meta mb-3">
                                        <tbody>
                                            <tr>
                                                <td class="td-label">โฮลเซลล์</td>
                                                <td class="td-data">
                                                    <span>{{$data->wholesale_name}}</span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="td-label">ประเทศ</td>
                                                <td class="td-data">
                                                    @if ( !empty($data->country_id) )
                                                    <span>{{$Fn->q('trperiod')->country_name($data->country_id)}}</span>
                                                    @else
                                                    <span>-</span>
                                                    @endif
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="td-label">พีเรียด <span>({{ Fn::getPeriodCount( $data->period_start ) }})</span></td>                                  <td class="td-data">
                                                    <span >{{ Fn::getPeriodConclusion( $data->period_start, $data->period_end ) }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="td-label">สายการบิน</td>
                                                <td class="td-data">
                                                    @if ( !empty($data->airline_id) )
                                                    <span>{{$data->airline_name}}</span>
                                                    @else
                                                    <span>-</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="td-label">โปรแกรม</td>
                                                <td class="td-data">
                                                    <span>{{$data->plan_days}}</span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="td-label">ราคา</td>
                                                <td class="td-data">
                                                    <div class="product-detail-price">
                                                        <span class="net" style="font-size: 1.571rem;color: red;font-weight: bold">{{number_format( $data->price_at )}}</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>


                                    <div class="product-detail-files row row-sm mb-3">
                                      @if(empty($data->files))
                                        <div class="col"><button class="btn btn-secondary btn-block btn-sm btn-word"><i class="fa fa-file-word-o mr-2"></i><span>DOC</span></button></div>
                                        <div class="col"><button class="btn btn-secondary btn-block btn-sm btn-pdf"><i class="fa fa-file-pdf-o mr-2"></i><span>PDF</span></button></div>
                                        @else
                                        @if(isset($decode_files[0]->url))
                                        <div class="col"><a href="{{$decode_files[1]->url}}" class="btn btn-primary btn-block btn-sm btn-word"><i class="fa fa-file-word-o mr-2"></i><span>DOC</span></a></div>
                                        <div class="col"><a href="{{$decode_files[0]->url}}" class="btn btn-danger btn-block btn-sm btn-pdf" target="_blank"><i class="fa fa-file-pdf-o mr-2"></i><span>PDF</span></a></div>

                                          @else
                                          <div class="col"><a href="{{asset($decode_files[1]->path)}}" class="btn btn-primary btn-block btn-sm btn-word"><i class="fa fa-file-word-o mr-2"></i><span>DOC</span></a></div>
                                          <div class="col"><a href="{{asset($decode_files[0]->path)}}" class="btn btn-danger btn-block btn-sm btn-pdf" target="_blank"><i class="fa fa-file-pdf-o mr-2"></i><span>PDF</span></a></div>

                                        @endif
                                        @endif
                                    </div>


                                    <hr>
                                    <div class="product-detail-actions">


                                        <button class="btn btn-success btn-block"><i class="fa fa-plus mr-2"></i>หยิบใส่ตระกร้า</button>


                                    </div>
                                </div>
                                <div class="col-9">
                                    <div class="product-detail-header pt-2 mb-3">

                                        <h1 class="product-detail-name" style="    margin-bottom: 0.571429rem;font-size: 2.857rem;font-weight: bold;">ฮานอย-ซาปา-ฟานซีปัน-นิงห์บิงห์-จ่างอาน 4วัน TG (ปีใหม่)</h1>

                                        <div class="mb-3 d-flex align-items-center" style="font-size: 1.571rem;text-transform: uppercase;font-weight: 500">
                                            <span class="product-detail-code mr-4" style="font-weight: bold;background: rgb(245, 162, 72);color: #fff; padding: 0px 0.571429rem;border-radius: 0.25rem">TDD59-149103</span>

                                            {{-- <div class="mr-4" style="height: 0.6rem;background: rgba(0, 0, 0, 0.1);width: 1px;"></div>
                                            <div class="mr-4">2019</div> --}}

                                            <div class="mr-4" style="height: 0.6rem;background: rgba(0, 0, 0, 0.1);width: 1px;"></div>

                                            <div class="mr-4" style="font-size:14px;line-height: 1">
                                                <a href="/store/wholesale/{{$data->wholesale_id}}">{{$data->wholesale_name}}</a>
                                            </div>

                                            @if ( !empty($data->country_id) )
                                            <div class="mr-4" style="height: 0.6rem;background: rgba(0, 0, 0, 0.1);width: 1px;"></div>
                                            <div class="group-country">
                                                <a href="/store/wholesale/{{$data->wholesale_id}}/country/{{$data->country_id}}" style="">{{$Fn->q('trperiod')->country_name($data->country_id)}}</a>
                                            </div>
                                            @endif
                                        </div>


                                    </div>

                                    <div class="product-detail-body mb-3">
                                        <nav>
                                            <div class="nav nav-tabs product-detail-tabs" id="nav-tab" role="tablist">
                                                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true"><span class="text">พีเรียด</span> <span class="count">(<span>{{ Fn::getPeriodCount( $data->period_start ) }}</span>)</span></a>
                                                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false"><span class="text">โปรแกรม</span> <span class="count">(<span>{{$data->plan_days}}</span>)</span></a>
                                                <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">เงื่อนไข/หมายเหตุ
                                                    </a>
                                            </div>
                                        </nav>
                                        <div class="tab-content" id="nav-tabContent">
                                            <div class="tab-pane fade active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                                <div class="py-3">
                                                    <table class="product-peroid-table">
                                                        <thead><tr>
                                                            <th >วันที่เดินทาง</th>
                                                            <th>ผู้ใหญ่</th>
                                                            <th>เด็ก</th>
                                                        </tr></thead>

                                                        <tbody>
                                                          {!!$tr_period!!}

                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">

                                                <div class="py-3">
                                                        <ul class="product-plans"><li><div class="product-plans-header d-flex"><div class="day"><span>วันที่</span><strong>1</strong></div><div class="product-plans-title flex-grow-1"><div class="editor-text">กรุงเทพฯ (สุวรรณภูมิ) - เมืองฮ่องกง (สนามบินเช็กแล็บก๊อก) - เมืองเซินเจิ้น                 </div></div></div><ul class="product-plans-content"><li><div class="label">11.00</div><div class="data"><div class="editor-text">คณะพร้อมกัน ณ ท่าอากาศยานนานาชาติสุวรรณภูมิ ชั้น 4 เคาน์เตอร์เช็คอิน Q สายการบิน Egypt Air โดยมีเจ้าหน้าที่ของบริษัทฯ คอยให้การต้อนรับ</div></div></li><li><div class="label">14.25</div><div class="data"><div class="editor-text">ออกเดินทางสู่ ท่าอากาศยานนานาชาติ เช็กแล็บก๊อก ประเทศฮ่องกง โดยสายการบิน Egypt Air เที่ยวบินที่ MS960</div></div></li><li><div class="label">18.00</div><div class="data"><div class="editor-text">เดินทางถึง ท่าอากาศยานนานาชาติ เช็กแล็บก๊อก ประเทศฮ่องกง หลังผ่านด่านตรวจคนเข้าเมือง และรับสัมภาระเรียบร้อย นำท่านเดินทางสู่ เมืองเซินเจิ้</div></div></li><li><div class="label">ค่ำ</div><div class="data"><div class="editor-text"></div></div></li></ul></li><li><div class="product-plans-header d-flex"><div class="day"><span>วันที่</span><strong>2</strong></div><div class="product-plans-title flex-grow-1"><div class="editor-text">เมืองเซินเจิ้น - วัดกวนอู - ร้านหยก - ร้านครีมไข่มุก - ร้านยางพารา – หมู่บ้านลี่เจียง – หล่อหวู่ช้องปิ้งเซ็นเตอร์ - เมืองจูไห่  พิเศษ!! เมนูเป็ดปักกิ่งและไวน์แดง                                   </div></div></div><ul class="product-plans-content"><li><div class="label">เช้า</div><div class="data"><div class="editor-text">บริการอาหารเช้า ณ ห้องอาหารของโรงแรม
                                                                นำท่านเดินทางสู่ วัดกวนอู (Kuan Au Temple) เทพเจ้ากวนอู สัญลักษณ์ของความซื่อสัตย์ นำท่านเดินทางสู่ ร้านหยก (Chinese Jade Shop) </div></div></li><li><div class="label">กลางวัน</div><div class="data"><div class="editor-text"> ร้านครีมไข่มุก (Pearl Cream Shop) </div></div></li><li><div class="label">ค่ำ</div><div class="data"><div class="editor-text"> ร้านยางพารา</div></div></li></ul></li><li><div class="product-plans-header d-flex"><div class="day"><span>วันที่</span><strong>3</strong></div><div class="product-plans-title flex-grow-1"><div class="editor-text">เมืองจู่ไห่ - ถนนคู่รัก - สาวงามหวีหนี่ –วัดผู่โถว - เมืองมาเก๊า - วัดอาม่า - ซากโบสถ์เซนต์ปอล - จตุรัสเซนาโด้ –ร้านของฝาก- เดอะ เวนีเชียน มาเก๊า  – เมืองจูไห่   พิเศษ!! เมนูเป่าฮื้อ</div></div></div><ul class="product-plans-content"><li><div class="label">เช้า</div><div class="data"><div class="editor-text">บริการอาหารเช้า ณ ห้องอาหารของโรงแรม
                                                                นำท่านนั่งรถชมทิวทัศน์ของ ถนนคู่รัก (The Lover’s Road)
                                                                นำท่านผ่านชม สาวงามหวีหนี่ หรือ จูไห่ ฟิชเชอร์ เกิร์ล (Zhuhai Fisher Girl) สาวงามกลางทะเล สัญลักษณ์ของเมืองจูไห่ นำท่านเดินทางสู่ วัดผู่โถว หรือ วัดผู่ถัวซาน</div></div></li><li><div class="label">กลางวัน</div><div class="data"><div class="editor-text">บริการอาหารกลางวัน ณ ภัตตาคาร  เมนู เป่าฮื้อ นำท่านเดินทางสู่ เมืองมาเก๊า (Macau) นำท่านเดินทางสู่ วัดอาม่า หรือเรียกอีกชื่อว่า วัดม่าก๊อก (A-Ma </div></div></li></ul></li><li><div class="product-plans-header d-flex"><div class="day"><span>วันที่</span><strong>4</strong></div><div class="product-plans-title flex-grow-1"><div class="editor-text">เมืองฮ่องกง - รีพลัส เบย์ - วัดแชกงหมิว - ร้านจิวเวอรี่ – ร้านหยก– Avenue of star - ถนนนาธาน  ย่านจิมซาจุ่ย - เมืองฮ่องกง (สนามบินเช็กแล็บก๊อก) - กรุงเทพฯ (สุวรรณภูมิ)                                 </div></div></div><ul class="product-plans-content"><li><div class="label">เช้า</div><div class="data"><div class="editor-text">บริการอาหารเช้า ณ ห้องอาหาร นำท่านเดินทางสู่ เมืองฮ่องกง (Hong Kong) เป็นเขตปกครองตนเองริมฝั่งทางใต้ของประเทศจีน นำท่านเดินทางสู่ รีพลัส เบย์ (Repulse Bay) หาดทรายรูปจันทน์เสี้ยวแห่งนี้ ที่สวยที่สุดแห่งหนึ่ง นำท่านเดินทางสู่จุดชมวิวเกาะฮ่องกง ณ วิคตอเรียพีค โดยรถบัส ในช่วงจุดชมวิวกลางเขา (Mid-Level) สัมผัสบรรยากาศบริสุทธิ์สดชื่น</div></div></li><li><div class="label">เที่ยง</div><div class="data"><div class="editor-text">บริการอาหารกลางวัน ณ ภัตตาคาร พิเศษ !! ห่านย่าง นำท่</div></div></li><li><div class="label">20.50</div><div class="data"><div class="editor-text"></div></div></li><li><div class="label">22.40</div><div class="data"><div class="editor-text"></div></div></li></ul></li></ul>
                                                </div>


                                                <hr>

                                                <h4>สรุปมื้ออาหาร</h4>


                                                <hr>

                                                <h4>โรงแรมที่พัก</h4>


                                            </div>
                                            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                                                    <div class="py-3">
                                                <p>Sint sit mollit irure quis est nostrud cillum consequat Lorem esse do quis dolor esse fugiat sunt do. Eu ex commodo veniam Lorem aliquip laborum occaecat qui Lorem esse mollit dolore anim cupidatat. Deserunt officia id Lorem nostrud aute id commodo elit eiusmod enim irure amet eiusmod qui reprehenderit nostrud tempor. Fugiat ipsum excepteur in aliqua non et quis aliquip ad irure in labore cillum elit enim. Consequat aliquip incididunt ipsum et minim laborum laborum laborum et cillum labore. Deserunt adipisicing cillum id nulla minim nostrud labore eiusmod et amet. Laboris consequat consequat commodo non ut non aliquip reprehenderit nulla anim occaecat. Sunt sit ullamco reprehenderit irure ea ullamco Lorem aute nostrud magna.</p>
                                                    </div>
                                            </div>
                                        </div>
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
