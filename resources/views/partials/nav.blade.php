
<button type="button" id="page-navigation-trigger" class="page-navigation-trigger"><span></span></button>
<nav id="page-navigation" class="page-navigation">

    <div class="layout__box o__has-rows h-100">

        <div class="layout__box page-navigation-header nav-primary-header"></div>

        <div class="layout__box o__scrolls o__flexes-to-1 position-relative nav-primary-body" role="navigation">
            @include('partials.nav.middle')
        </div>

        <div class="layout__box nav-primary-footer">
            @include('partials.nav.bottom')
        </div>

    </div>
</nav>
