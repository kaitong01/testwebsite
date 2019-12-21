<div style="background: linear-gradient(135deg,#e4e6f5,#ecf6ff 39%,#ddecff);background-size: 100% 302px;background-repeat: no-repeat;">
    <div class="business-settings-container" style="margin-left: auto;margin-right: auto">

        <div class="business-settings-header" style="background: transparent">

            <div class="d-flex">
                <div>
                    <h1 class="title">ปรับแต่งแบนเนอร์บนเว็บไซต์</h1>
                    {{-- <p class="sub-title"></p> --}}
                </div>
            </div>

        </div>


        @foreach ($data['banners'] as $key => $banner)
        <div class="business-settings-body">

            <form action="/site/banners" method="POST" data-plugin="formSubmit">
             {{ csrf_field() }}
                <input type="hidden" name="theme_id" value="{{ $banner['theme_id'] }}" autocomplete="off">
                <input type="hidden" name="banner_id" value="{{ $banner['id'] }}"  autocomplete="off">
                <input type="hidden" name="position" value="{{ $banner['position'] }}"  autocomplete="off">

                @if ($banner->item)
                <input type="hidden" name="id" value="{{ $banner->item->id }}" autocomplete="off">
                @endif

                <div class="business-settings-section">

                    <div class="business-settings-section-header">

                        <div class=" d-flex justify-content-between">
                            <div>
                                <h2>แบนเนอร์: {{$banner['name']}}</h2>
                                {{-- <p></p> --}}
                            </div>

                        </div>
                    </div>

                    <div class="business-settings-section-body">

                        <?php $Fn = new Fn; ?>

                        <div style="width:{{$banner['width']}}px"><?=$Fn->q('form')->imageCover( [

                        'name' => 'file1',
                        'width' => $banner['width'],
                        'height' => $banner['height'],

                        'dropzoneText' => 'แบนเนอร์',

                        'cancelFileName' => "file1_cancel_file",

                        'src' => !empty($banner->item->path)? asset("storage/{$banner->item->path}"): null,

                        ] )?></div>


                        <div class="mt-3">

                            <label class="mb-1" for="banner_{{$banner['id']}}_caption">คำอธิบาย</label>
                            <textarea class="form-control" id="banner_{{$banner['id']}}_caption" name="caption" rows="1" data-plugin="autosize">{{ $banner->item->caption ?? '' }}</textarea>

                        </div>

                        <div class="mt-3">
                            <label class="mb-1" for="banner_{{$banner['id']}}_permalink">ลิงค์</label>
                            <div class="input-group">

                                <input type="text" class="form-control" id="banner_{{$banner['id']}}_permalink" name="permalink" value="{{ $banner->item->permalink ?? '' }}">

                                <div class="input-group-append">
                                    <select type="text" name="target" class="input-group-text">
                                        @foreach ($data['target'] as $target)
                                        <option value="{{$target['id']}}"

                                        @if ($banner->item)
                                            @if ($banner->item->target==$target['id'])
                                            {{  ' selected'  }}
                                            @endif
                                        @endif

                                        >{{$target['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>


                    </div>
                    {{-- end: business-settings-section-body --}}

                    <div class="business-settings-section-footer d-flex justify-content-between"><div></div> <div><button type="submit" class="btn btn-primary btn-submit">บันทึก</button></div></div>

                </div>
            </form>

        </div>
        {{-- end business-settings-body --}}
        @endforeach
    </div>
</div>
