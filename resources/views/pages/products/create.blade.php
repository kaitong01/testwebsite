@extends('layouts.admin')


@section('title', isset($data)? 'แก้ไขซีรีย์ทัวร์':'เพิ่มซีรีย์ทัวร์')

@section('content')

<?php

$nav = array();
$nav[] = array('id'=>'basics', 'title'=>'ข้อมูลเบื้องต้น', 'subtitle'=>'รายละเอียดเนื้อหาเกี่ยวซีรีย์ทัวร์');
$nav[] = array('id'=>'plans', 'title'=>'โปรแกรมเดินทาง', 'subtitle'=>'กรอกรายละเอียดแผนการเดินทาง ละเอียดที่พัก โรงแรม และมืออาหาร');
$nav[] = array('id'=>'period', 'title'=>'พีเรียดเดินทาง', 'subtitle'=>'กำหนดวันที่เดินทางและราคา');
$nav[] = array('id'=>'conditions', 'title'=>'เงื่อนไข', 'subtitle'=>'ข้อจำกัดหรือหมายเหตุ สำหรับการท่องเที่ยวหรือการจอง');
$nav[] = array('id'=>'protos', 'title'=>'รูปภาพ', 'subtitle'=>'อัปโหลดรูปภาพประกอบ');
$nav[] = array('id'=>'docs', 'title'=>'ไฟล์', 'subtitle'=>'อัปโหลดไฟล์เอกสาร Word และ PDF');
$nav[] = array('id'=>'wholesale', 'title'=>'โฮลเซลล์', 'subtitle'=>'กำหนดโฮลเซลล์');
$nav[] = array('id'=>'seo', 'title'=>'SEO', 'subtitle'=>'');
$nav = json_decode( json_encode($nav) );

// {{ $item ? asset("/tours/series/{$item->id}/edit"): asset('/tours/series/')}}

?>
<div style="background: linear-gradient(135deg, rgb(228, 230, 245), rgb(236, 246, 255) 39%, rgb(221, 236, 255)) 0% 0% / 100% 302px no-repeat;">
    <form action="{{ isset($data) ? asset("/tours/series/{$data->id}"): asset('/tours/series/')}}" method="post" class="business-settings-container" style="margin-left: auto; margin-right: auto;" data-plugins="formSubmit|seriesForm">
        {{ csrf_field() }}

        @isset($data)
        <input type="hidden" name="_method" value="PUT" autocomplete="off">
        @else
        <input type="hidden" name="_method" value="POST" autocomplete="off">
        @endif

        <div class="business-settings-header" style="background: transparent;">
            <div class="d-flex">

                <div>

                @isset($data)
                    <h1 class="title">แก้ไขแพ็คเกจทัวร์</h1>
                    {{-- <p class="sub-title">แก้ไขข้อมูลล่าสุด: </p> --}}
                @else
                    <h1 class="title">เพิ่มแพ็คเกจทัวร์ใหม่</h1>
                @endisset

                </div>
            </div>

        </div>
        {{-- end: header --}}

        <div class="business-settings-body">

            <div class="row">

                <div class="col-10" role="content">
                    @foreach ($nav as $value)
                    <div data-section-id="{{$value->id}}">
                        @include("pages.products.createForms.{$value->id}")
                    </div>
                    @endforeach

                    <div class="pt-5">
                        <div class="d-flex align-items-center justify-content-between" role="actions">
                            <div>
                                @isset ( $data )
                                <a href="{{asset('/por/'.$data->id.'/delete')}}" data-plugin="lightbox" class="btn btn-danger" style="white-space: nowrap;">ลบถาวร</a>

                                @endif
                            </div>
                            <div class="d-flex align-items-center">
                                <select class="form-control input-group-text" name="status">
                                    @foreach ($statusList as $val)

                                    <option value="{{$val->id}}"@isset($data)

                                            @if ($data['status']==$val->id){{' selected=""'}} @endif

                                            @else
                                            @if (1==$val->id){{' selected=""'}} @endif

                                        @endisset>{{$val->name}}</option>

                                    @endforeach
                                </select>

                                @isset ( $data )
                                <button type="submit" class="btn btn-primary ml-2" style="white-space: nowrap;">บันทึก</button>
                                @else
                                <button type="submit" class="btn btn-success ml-2" style="white-space: nowrap;">เพิ่มแพ็คเกจทัวร์</button>
                                @endif

                            </div>
                        </div>
                    </div>
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
