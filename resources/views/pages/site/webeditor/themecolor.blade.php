<?php

$colors = [];
if( !empty( $data->colors )){
    $colors = explode(';', $data->colors);
}

?>


<form action="{{asset('/site/webeditor/themecolor')}}" method="POST">

<div class="container">
    <br><br>

    @csrf

    @isset( $data )
    <input type="hidden" name="theme_id" value="{{$data->id}}">
    @endisset
    <div class="row" data-plugin="acolorpicker">

        <div class="col-7">
            <label>header</label>
            <div class="row">

                <div class="col-6">
                    <div class="mb-3">
                        <label for="">1.background</label>
                        <input type="text" class="form-control colorpicker" data-role="header1" data-type="background" name="colors[]" value="{{ $colors[0] ?? '' }}">
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label for="">2.color</label>
                        <input type="text" class="form-control colorpicker" data-role="header2" data-type="color" name="colors[]"
                         value="{{ $colors[1] ?? '' }}">
                    </div>
                </div>
            </div>

            <label>Body</label>
            <div class="row">
                <div class="col-6">
                    <div class="mb-3">
                        <label for="">3.background</label>
                        <input type="text" class="form-control colorpicker" data-role="body1" data-type="background" name="colors[]" value="{{ $colors[2] ?? '' }}">
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label for="">4.color</label>
                        <input type="text" class="form-control colorpicker" data-role="body2" data-type="color" name="colors[]"
                         value="{{ $colors[3] ?? '' }}">
                    </div>
                </div>
            </div>
            <label>hotline</label>
            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label for="">5.background</label>
                        <input type="text" class="form-control colorpicker" data-role="hotline" data-type="background" name="colors[]" value="{{ $colors[4] ?? '' }}">
                    </div>
                </div>
                <div class="col">
                    <div class="mb-3">
                        <label for="">6.Box color</label>
                        <input type="text" class="form-control colorpicker" data-role="hotline" data-type="color" name="colors[]"
                        value="{{ $colors[5] ?? '' }}">
                    </div>
                </div>
            </div>
            <label for="">Slideshow</label>
            <div class="mb-3">
                <label for="">7.background</label>
                <input type="text" class="form-control colorpicker" data-role="Slideshow" data-type="background" name="colors[]"
                value="{{ $colors[6] ?? '' }}">
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="mb-3">
                        <label for="">8.Slideshow color</label>
                        <input type="text" class="form-control colorpicker" data-role="Slideshow1" data-type="background" name="colors[]" value="{{ $colors[7] ?? '' }}">
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label for="">9.Font Color</label>
                        <input type="text" class="form-control colorpicker" data-role="Slideshow1" data-type="color" name="colors[]" value="{{ $colors[8] ?? '' }}">
                    </div>
                </div>
            </div>
            <label>footer</label>
            <div class="mb-3">
                <label for="">10.background</label>
                <input type="text" class="form-control colorpicker" data-role="footer" data-type="background" name="colors[]"
                 value="{{ $colors[9] ?? '' }}">
            </div>

            <div class="mb-3">
                <label for="">11.color</label>
                <input type="text" class="form-control colorpicker" data-role="footer" data-type="color" name="colors[]"
                 value="{{ $colors[10] ?? '' }}">
            </div>


         <button type="submit" class="btn btn-primary">บันทึก</button>

        </div>
        <div class="card">
  <div class="card-body">
  <div class="col-5">


<div id="preview" class="preview">
    <div class="span3">
        <div id="demo-page" class="demo-page" style="width: 300px;border-radius: 5px;overflow: hidden;">

            <div class="key-1 key-2">

                <header class="demo-page-section demo-page-header key-3" role="header1" style="position: relative;height: 30px;">
                    <span class="key-4" role="header2">2 Header</span>

                    <div style="position: absolute;padding: 2px 8px;background-color: #cf4c3c;color: #fff;top: 6px;right: 10px;font-size: 12px;border-radius: 3px;" role="hotline" class="key-5 key-6">Hotline</div>
                </header>


                <!-- sli -->
                <div class="key-7" style="height: 100px;background-color: #f5f5f5;position: relative;" role="Slideshow">

                        <span style="font-size: 10px;position: absolute;bottom: 10px;right: 10px;padding:4px 5px;" role="Slideshow1" class="key-8 key-9">3.1 Slideshow</span>



                </div>
                <div style="background-color: #f8f8f8;">
                    <div style="text-align: center;padding-top: 15px" role="body2">จุดหมายปลายทางยอดนิยม</div>
                    <div style="position: relative;padding: 5px;display: flex;">

                        <div style="width: 20%;">
                            <div style="margin:5px;background-color: #fff;height: 30px;border-radius: 3px" role="Slideshow" class="key-7"></div>
                        </div>
                        <div style="width: 20%;">
                            <div style="margin:5px;background-color: #fff;height: 30px;border-radius: 3px" role="Slideshow" class="key-7"></div>
                        </div>
                        <div style="width: 20%;">
                            <div style="margin:5px;background-color: #fff;height: 30px;border-radius: 3px" role="Slideshow" class="key-7"></div>
                        </div>
                        <div style="width: 20%;">
                            <div style="margin:5px;background-color: #fff;height: 30px;border-radius: 3px" role="Slideshow" class="key-7"></div>
                        </div>
                        <div style="width: 20%;">
                            <div style="margin:5px;background-color: #fff;height: 30px;border-radius: 3px" role="Slideshow" class="key-7"></div>
                        </div>

                    </div>
                </div>
                <div role="body1">
                    <div style="font-size: 14px;text-align: center;padding-bottom: 0;padding-top: 15px" role="body2">ทัวร์แนะนำ</div>
                    <div class="" style="position: relative;padding: 5px;display: flex;">


                        <div style="width: 25%;">
                            <div style="margin:5px;background-color: #fff;height: 100px;border:1px solid rgba(0,0,0,.1);border-radius: 3px">
                                <div style="padding-top:100%;height: 0;background-color: #ccc" class="key-7" role="Slideshow"></div>
                            </div>
                        </div>
                        <div style="width: 25%;">
                            <div style="margin:5px;background-color: #fff;height: 100px;border:1px solid rgba(0,0,0,.1);border-radius: 3px">
                                <div style="padding-top:100%;height: 0;background-color: #ccc" class="key-7" role="Slideshow"></div>
                            </div>
                        </div>
                        <div style="width: 25%;">
                            <div style="margin:5px;background-color: #fff;height: 100px;border:1px solid rgba(0,0,0,.1);border-radius: 3px">
                                <div style="padding-top:100%;height: 0;background-color: #ccc" class="key-7" role="Slideshow"></div>
                            </div>
                        </div>
                        <div style="width: 25%;">
                            <div style="margin:5px;background-color: #fff;height: 100px;border:1px solid rgba(0,0,0,.1);border-radius: 3px">
                                <div style="padding-top:100%;height: 0;background-color: #ccc" class="key-7" role="Slideshow"></div>
                            </div>
                        </div>

                    </div>
                    <div style="font-size: 14px;text-align: center;padding-bottom: 0;padding-top: 15px" role="body2">ทัวร์มาใหม่</div>
                    <div class="key-" style="position: relative;padding: 5px;display: flex;">


                        <div style="width: 25%;">
                            <div style="margin:5px;background-color: #fff;height: 100px;border:1px solid rgba(0,0,0,.1);border-radius: 3px">
                                <div style="padding-top:100%;height: 0;background-color: #ccc" class="key-7" role="Slideshow"></div>
                            </div>
                        </div>
                        <div style="width: 25%;">
                            <div style="margin:5px;background-color: #fff;height: 100px;border:1px solid rgba(0,0,0,.1);border-radius: 3px">
                                <div style="padding-top:100%;height: 0;background-color: #ccc" class="key-7" role="Slideshow"></div>
                            </div>
                        </div>
                        <div style="width: 25%;">
                            <div style="margin:5px;background-color: #fff;height: 100px;border:1px solid rgba(0,0,0,.1);border-radius: 3px">
                                <div style="padding-top:100%;height: 0;background-color: #ccc" class="key-7" role="Slideshow"></div>
                            </div>
                        </div>
                        <div style="width: 25%;">
                            <div style="margin:5px;background-color: #fff;height: 100px;border:1px solid rgba(0,0,0,.1);border-radius: 3px">
                                <div style="padding-top:100%;height: 0;background-color: #ccc" class="key-7" role="Slideshow"></div>
                            </div>
                        </div>

                    </div>


                    <div>
                        <div style="font-size: 14px;text-align: center;padding-bottom: 0;padding-top: 15px" role="body2">ทัวร์ถูก</div>
                        <div class="key-" style="position: relative;padding: 5px;display: flex;">


                            <div style="width: 25%;">
                                <div style="margin:5px;background-color: #fff;height: 100px;border:1px solid rgba(0,0,0,.1);border-radius: 3px">
                                    <div style="padding-top:100%;height: 0;background-color: #ccc" class="key-7" role="Slideshow"></div>
                                </div>
                            </div>
                            <div style="width: 25%;">
                                <div style="margin:5px;background-color: #fff;height: 100px;border:1px solid rgba(0,0,0,.1);border-radius: 3px">
                                    <div style="padding-top:100%;height: 0;background-color: #ccc" class="key-7" role="Slideshow"></div>
                                </div>
                            </div>
                            <div style="width: 25%;">
                                <div style="margin:5px;background-color: #fff;height: 100px;border:1px solid rgba(0,0,0,.1);border-radius: 3px">
                                    <div style="padding-top:100%;height: 0;background-color: #ccc" class="key-7" role="Slideshow"></div>
                                </div>
                            </div>
                            <div style="width: 25%;">
                                <div style="margin:5px;background-color: #fff;height: 100px;border:1px solid rgba(0,0,0,.1);border-radius: 3px">
                                    <div style="padding-top:100%;height: 0;background-color: #ccc" class="key-7" role="Slideshow"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div role="footer">FOOTER</div>

        </div>

        <div>
            <!-- <div role="header">HEADER</div>

<div role="Slideshow">BODY</div>  -->


        </div>

    </div>
</div>

</div>
</div>
</div>

</div>
  </div>
</div>



@section('footer_scripts')

<link href="{{ asset('assets/bootstrap-colorpicker/css/bootstrap-colorpicker.css') }}" rel="stylesheet">

@endsection
</div>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
</form>
