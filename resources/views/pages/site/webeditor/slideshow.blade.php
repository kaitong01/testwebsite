@extends('layouts.admin')

@section('title', '')

@section('content')
<body>
	<div class="container-fluid" data-plugin="PageSlideshow">
		<div class="col-lg-8 col-md-12 col-sm-12" >

			<div class="col-lg-8 col-md-12 col-sm-12" >


				<form class="insertform" method="post" action="{{route('silde.store')}}" enctype="multipart/form-data"enctype="multipart/form-data">
					@csrf
					<div class=" slideall" role="listsbox" >

				<!-- <div class="groupslide" id="groupslide">
					<input type="file" name="slidefile" id="file" class="slideinput choosefile" name="slide1"  />
					<label for="file" class="slidefile">เลือกไฟล์</label>
				</div> -->
				
				<div class="file-upload">
					<div class="file-select" id="file-select">
						<div class="file-select-button" id="fileName">Choose File</div>
						<div class="file-select-name" id="noFile">No file</div> 
						<input type="file" name="chooseFile[]" id="chooseFile"><br>
					</div>
				</div>
				
			</div><div class="btngroup float-right">
			<a class="btn btn-danger romoveinput float-right" id="removeinput"><i class=""></i>-</a>
			<a class="btn btn-primary addinput float-right" id="addinput"><i class="fa fa-plus"></i></a>
		</div>
			<button class="btn btn-primary js-add " id="addform" type="submit" value="Submit"><i class="fa fa-plus"></i> เพิ่มข้อมูล</button>
		
</form>
		


		<!-- <button class="btn btn-primary js-add " id="addform" type="submit" value="Submit"><i class=""></i>เพิ่มข้อมูล</button> -->
	</div>


	@if(!empty($slideimage))
	@foreach($slideimage as $key => $value)
	<div class="col-lg-8 col-md-12 col-sm-12">
		<div class="cardlist">
			<div class="card" style="width: rem;">
			<img src="{{asset("storage/{$value->path}")}}" class="card-img-top" alt="...">
			<div class="card-body">
				<a href="{{action('CompaniesSlidecontroller@delete',$value['id'])}}" class="btn btn-danger btn-block delpic"><i class="fa fa-trash"></i> ลบรูปภาพ</a>
			</div>
		</div>
		</div>
		
	</div>
	@endforeach
	@endif
</div>
</div>
</body>
@endsection