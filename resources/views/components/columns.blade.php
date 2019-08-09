<div class="layout__box o__flexes-to-1 o__has-columns">


    @if( isset($nav) )
        <div class="layout__box o__has-columns">
            {{ $nav }}
        </div>
    @endif

    <div class="layout__box o__has-rows o__flexes-to-1">
        {{ $slot }}
    </div>

</div>
