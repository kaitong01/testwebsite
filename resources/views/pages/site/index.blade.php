@extends('layouts.admin')

@section('title', isset( $title ) ? $title : 'ปรับแต่งไซต์')

@section('content')

    @component('components.columns', [
        'navleft'=> ''
    ])

        @slot('nav')
            @component('components.navleft', [
                'title' => 'ปรับแต่งไซต์',

                'current' => $navleftItemsCurrentTab,

                "items" => $navleftItems,
            ])

            @endcomponent

        @endslot

        @isset( $inc )
            @includeIf("pages.site.{$inc}", ['some' => 'data'])
        @endisset

    @endcomponent

@endsection
