@extends('index')


@section('title', 'การตั้งค่า')


@section('content')
	

	<div class="content-primary layout__box o__flexes-to-1 o__has-rows">
		<div class="layout__box o__flexes-to-1 o__has-columns">

		    @component('layouts.settings.sidebar')

		    @endcomponent


	    
		    <div class="layout__box o__has-rows o__flexes-to-1">
		    	
		    	Page Settings
		    </div>
	        
    	</div>
    </div>


@endsection
