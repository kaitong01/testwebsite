<div class="container">

    <div class="section-hero pt-5 mb-5">
        <h1>เลือกประเทศ</h1>
    </div>

    @foreach ($regionList as $region)

    <section class="section section-region mb-4">

        <h2 class="border-bottom mb-4 pb-1">{{$region['name']}}</h2>

        <div class="row">
            @foreach ($region['items'] as $item)


            <div class="col-2 mb-3">

                <label class="checkbox d-block border rounded" style="height: 45px;overflow: hidden">

                    <div class="d-flex align-items-center">
                        {{-- <input type="checkbox" name="" value="{{$item['id']}}"> --}}

                        <i class="flag-icon flag-icon-{{ strtolower($item['code']) }}" style="width: 60px;height: 45px;"></i>

                        <div class="pl-2 fs-13 y-ellipsis clamp-2 text-uppercase" stlye="line-height: 1;" lang="{{$item['lang'] ?? ''}}">{{$item['name']}}</div>
                    </div>
                </label>
            </div>

            @endforeach
        </div>
    </section>

    @endforeach
</div>
