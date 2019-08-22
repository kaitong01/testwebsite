@extends('layouts.admin')

@section('title', $title)

@section('content')

    @isset( $datatable )
    @component('components.datatable', $datatable)

        @isset( $datatable->actions_right )
        @slot('actions_right')
            $datatable->actions_right
        @endslot
        @endisset


        @isset( $datatable->tabs )
            @slot('nav')
            $datatable->tabs
            @endslot
        @endisset


    @endcomponent
    @endisset

@endsection
