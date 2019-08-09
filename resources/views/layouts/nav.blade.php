
<button type="button" id="page-navigation-trigger" class="page-navigation-trigger"><span></span></button>
<nav id="page-navigation" class="page-navigation">

    <div class="layout__box o__has-rows h-100">

        <div class="layout__box page-navigation-header"></div>

        <div class="layout__box o__scrolls o__flexes-to-1 position-relative" role="navigation">
            @include('layouts.nav.middle')
        </div>

        <div class="layout__box">
            @include('layouts.nav.bottom')
        </div>


    </div>
</nav>

@section('footer_scripts')
    @include('scripts.nav')
@endsection
