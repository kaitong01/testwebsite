
<?php

foreach ($data['items'] as $key => $item){
    echo '<link href="https://fonts.googleapis.com/css?family='.$item->name.'" rel="stylesheet">';
}
?>
<div style="background: linear-gradient(135deg,#e4e6f5,#ecf6ff 39%,#ddecff);background-size: 100% 302px;background-repeat: no-repeat;">
    <div class="business-settings-container" style="margin-left: auto;margin-right: auto">

        <div class="business-settings-header" style="background: transparent">

            <div class="d-flex">
                <div>
                    <h1 class="title">ปรับแต่งฟอนต์บนเว็บไซต์</h1>
                    {{-- <p class="sub-title"></p> --}}
                </div>
            </div>

        </div>
        <div class="business-settings-body">

            <div  class="business-settings-section">

                <div class="business-settings-section-header">

                    <div class=" d-flex justify-content-between">
                        <div>
                            <h2>ฟอนต์</h2>
                            {{-- <p></p> --}}
                        </div>
                    </div>
                </div>


                <div class="business-settings-section-body">

                    <ul class="row" data-plugin="switchFont">
                        @foreach ($data['items'] as $item)
                        <li class="col-4 mb-3 {{ $item->id==$data['active']? 'active': '' }}">
                            <div class="font-preview-fonts-module fonts-module h-100">
                            <label class="radio ">

                                <div class="d-flex">
                                    <input type="radio" name="font_id" value="{{ $item->id }}"{{ $item->id==$data['active']? ' checked': '' }} >

                                    <h3 class="fonts-module-title ml-2">{{$item->name}}</h3>
                                </div>
                                {{-- <h3 class="fonts-module-subtitle">{{$item->name}}</h3> --}}
                                <div class="font-preview-controls-container">
                                    <div  content-editable="true" style="{{ $item->specify }}">
                                    {{$item->preview}}
                                    </div>
                                </div>
                            </label>
                            </div>
                        </li>
                        @endforeach

                    </ul>
                </div>

            </div>


        </div>
        {{-- end business-settings-body --}}
    </div>
</div>
