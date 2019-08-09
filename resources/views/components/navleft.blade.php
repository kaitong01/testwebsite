<div class="navleft layout__box o__has-rows">

    @if( isset( $title ) )
    <div class="navleft-header pt-3 px-3 mb-2 layout__box">
        <h1 class="navleft-header-title">{{ $title }}</h1>
    </div>
    @endif

    <div class="navleft-sections layout__box">
        <ul class="navleft-nav">
            @foreach ($items as $key=> $menu)
            <li class="navleft-item is-open">
                @if (!empty($menu['name']))

                    <a href="#" class="navleft-link navleft-title">
                        <span class="navleft-text">{{$menu['name']}}</span>
                        {{-- <span class="navleft-arrow"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><path d="M7.25 4L6 5.114l2.663 2.887L6 10.886 7.25 12 11 8.001z"></path></svg></span> --}}
                    </a>

                @endempty

                @if (!empty($menu['items']))
                    <div class="navleft-dropdown"><ul class="navleft-sub">
                    @foreach ($menu['items'] as $item)
                        <li class="navleft-item">
                            <a href="#" class="navleft-link">
                                <span class="navleft-text">{{$item['name']}}</span>
                                <span class="navleft-count">
                                    @if (!empty($item['count']))
                                        {{ $item['count'] }}
                                    @else
                                        0
                                    @endif
                                </span>
                            </a>
                        </li>
                    @endforeach
                    </div></ul>
                @endif

            </li>
            @endforeach
        </ul>

    </div>
</div>
