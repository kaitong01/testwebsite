@extends('layouts.admin')

@section('title', isset($data)? 'แก้ไขซีรีย์ทัวร์':'เพิ่มซีรีย์ทัวร์')

@section('content')

<?php

$Fn = new Fn;

$nav = [];
$nav[] = array('id'=>'basics', 'title'=>'ข้อมูลเบื้องต้น', 'subtitle'=>'รายละเอียดเนื้อหาเกี่ยวซีรีย์ทัวร์');
$nav[] = array('id'=>'plans', 'title'=>'โปรแกรมเดินทาง', 'subtitle'=>'กรอกรายละเอียดแผนการเดินทาง ละเอียดที่พัก โรงแรม และมืออาหาร');
$nav[] = array('id'=>'period', 'title'=>'พีเรียดเดินทาง', 'subtitle'=>'กำหนดวันที่เดินทางและราคา');
$nav[] = array('id'=>'conditions', 'title'=>'เงื่อนไข', 'subtitle'=>'ข้อจำกัดหรือหมายเหตุ สำหรับการท่องเที่ยวหรือการจอง');
$nav[] = array('id'=>'protos', 'title'=>'รูปภาพ', 'subtitle'=>'อัปโหลดรูปภาพประกอบ');
$nav[] = array('id'=>'docs', 'title'=>'ไฟล์', 'subtitle'=>'อัปโหลดไฟล์เอกสาร Word และ PDF');

// $nav[] = array('id'=>'wholesale', 'title'=>'โฮลเซลล์', 'subtitle'=>'กำหนดโฮลเซลล์');
$nav[] = array('id'=>'seo', 'title'=>'SEO', 'subtitle'=>'ปรับแต่งทัวร์คุณให้ติดอันดับบนเครื่องมือการค้นหา');

$nav = json_decode( json_encode($nav) );

// {{ $item ? asset("/tours/series/{$item->id}/edit"): asset('/tours/series/')}}

?>
<div style="background: linear-gradient(135deg, rgb(228, 230, 245), rgb(236, 246, 255) 39%, rgb(221, 236, 255)) 0% 0% / 100% 302px no-repeat;">
    <form action="{{ !empty($data) ? asset("/tours/series/{$data->id}"): asset('/tours/series/')}}" method="post" class="business-settings-container" style="margin-left: auto; margin-right: auto;" data-plugins="formSubmit|seriesForm|formseo">
        {{ csrf_field() }}

        @isset($data)
        <input type="hidden" name="_method" value="PUT" autocomplete="off">
        <input type="hidden" name="id" value="{{$data->id}}" autocomplete="off">
        @else
        <input type="hidden" name="_method" value="POST" autocomplete="off">
        @endif

        <div class="business-settings-header" style="background: transparent;">

                @isset($data)
                    <h1 class="title">แก้ไขทัวร์ : {{$data->name}}</h1>
                    <p class="sub-title">แก้ไขข้อมูลล่าสุด: <?=$Fn->q('time')->live( $data->updated_at )?></p>


                    @if ($data->wholesale_id<>0)
                    <div class="alert alert-danger mt-4"><h4 class="alert-heading mb-2" style="font-size: 100%; font-weight: bold;">หมายเหตุสำคัญ:</h4>

                        <p>ข้อมูลนี้นำเข้าจากโฮลเซลล์ : {{$data->wholesale->name}}</p>
                    </div>
                    @endif

                @else
                    <h1 class="title">เพิ่มทัวร์ใหม่</h1>
                @endisset


        </div>
        {{-- end: header --}}

        <div class="business-settings-body">

            <div class="row">

                <div class="col-10" role="content">
                    @foreach ($nav as $value)
                    <div data-section-id="{{$value->id}}">
                        @include("pages.product.forms.{$value->id}")
                    </div>
                    @endforeach

                    {{-- footer --}}
                    <div class="pt-5">
                        <div class="d-flex align-items-center justify-content-between" role="actions">
                            <div>
                                @if( !empty($data) )

                                {{-- <a href="{{asset('/products/'.$data->id.'/delete')}}" data-plugin="lightbox" class="btn btn-danger" style="white-space: nowrap;">ลบถาวร</a> --}}

                                @endif
                            </div>

                            <div class="d-flex align-items-center">
                                <select class="form-control input-group-text outline" name="status" data-plugin="input__status">
                                    @foreach ($statusList as $val)

                                    <option value="{{$val['id']}}"@if( !empty($data) )

                                            @if ($data['status']==$val['id']){{' selected=""'}} @endif

                                            @else
                                            @if (2==$val['id']){{' selected=""'}} @endif

                                        @endisset>{{$val['name']}}</option>

                                    @endforeach
                                </select>

                                @if ( !empty($data) )
                                <button type="submit" class="btn btn-primary ml-2" style="white-space: nowrap;padding-left: 25px;padding-right: 25px;">บันทึก</button>
                                @else
                                <button type="submit" class="btn btn-success ml-2" style="white-space: nowrap;padding-left: 25px;padding-right: 25px;">เพิ่มทัวร์</button>
                                @endif

                            </div>
                        </div>
                    </div>
                    {{-- footer --}}
                </div>

                <div class="col-2">
                    <div class="section-nav">
                        <ul class="list-unstyled">
                            @foreach ($nav as $value)
                            <li class="section-nav-item" data-section-action="{{$value->id}}">
                                <div class="section-nav-link">
                                    <div class="section-nav-title"><strong>{{$value->title}}</strong></div>
                                    {{-- <div class="section-nav-subtitle"><span></span></div> --}}
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

            </div>


        </div>


        {{-- end: body --}}
    </form>
    {{-- end: container --}}
</div>

@endsection
