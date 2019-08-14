
<div class="navleft layout__box">
    <div class="navleft-wrap navleft-fixed layout__box o__has-rows">

        @if( isset( $title ) )
        <div class="navleft-header pt-3 px-3 mb-2 layout__box">
            <h1 class="navleft-header-title">{{ $title }}</h1>
        </div>
        @endif
        <div class="navleft-body layout__box">
            
            @foreach ($items as $key=> $menu)

            <ul class="navleft-nav">

                @if (!empty($menu['name']))
                <li class="navleft-item head"><span>{{ $menu['name'] }}</span></li>
                   
                @endempty

                @if (!empty($menu['items']))
                
                @foreach ($menu['items'] as $value)



                <?php 
                $active = ''; 
                if( isset($current) ){

                    if( $current==$value['id'] ){
                        $active = ' active'; 
                    }
                }


                ?>

                <li class="navleft-item{{ $active }}">

                    <a href="{{$value['id']}}" class="navleft-link navleft-title">
                        <span class="navleft-text">{{$value['name']}}</span>

                        @isset( $value['count'] )
                        <span class="navleft-count">{{ $value['count'] }}</span>
                        @endisset
                    </a>
                </li>

                @endforeach
                @endif

            </ul>
            @endforeach
            
        </div>
    </div>
</div>
