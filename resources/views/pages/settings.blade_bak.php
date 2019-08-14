@extends('index')


@section('title', 'การตั้งค่า')


@section('content')
	

	<div class="content-primary layout__box o__flexes-to-1 o__has-rows">
		<div class="layout__box o__flexes-to-1 o__has-columns">

		    @component('layouts.settings.sidebar')
		    	@isset($page_current_tab)
		    	{{ $page_current_tab }}
		    	@endisset
		    @endcomponent


	    
		    <div class="layout__box o__has-rows o__flexes-to-1">
		    	
		    	 <h1>Page Settings, @isset($page_current_tab) {{ $page_current_tab }} @endisset</h1>
		    </div>
	        
    	</div>
    </div>


@endsection
