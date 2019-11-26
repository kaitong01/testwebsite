<?php

// use Illuminate\Support\Facades\Session;

$site_menu_open = Session::get('site_menu_open') || true;

$bodyCls = '';
if( !empty($site_menu_open) ){
    $bodyCls .= $bodyCls!=''? ' ':'';
    $bodyCls .= 'is-pushed-left';
}

if( Auth::guest() ){
    $bodyCls .= $bodyCls!=''? ' ':'';
    $bodyCls .= 'logged-out';
}
else{
    $bodyCls .= $bodyCls!=''? ' ':'';
    $bodyCls .= 'logged-in';
}

if( !empty($bodyCls) ){
    $bodyCls = ' class="'.$bodyCls.'"';
}


?><!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@if (trim($__env->yieldContent('title')))@yield('title') | @endif {{ config('app.name', 'MANAGER/Easy Web Tour') }}</title>

    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <script src="/js/custom.js"></script>
</head>
{{-- $bodyCls --}}
<body>

    <div id="doc">
        @auth
        <header id="page-header" class="page-header">

            @include('partials.topbar')

            @auth
                @include('partials.nav')
            @endauth
        </header>
        @endauth

        <main id="page-main" class="page-main layout__box o__flexes-to-1 o__has-rows">

            @yield('content')

        </main>
    </div>


    <!-- Modals -->
    <div class="modals">
        @yield('modals')
    </div>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

    @yield('footer_scripts')
</body>
</html>
