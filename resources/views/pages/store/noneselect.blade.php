@extends('layouts.admin')

@section('title', 'คลังแพคเกจทัวร์')

@section('content')

   <div class="row">
     <div class="col-12 text-center">
        <h1>กรุณาเลือก Wholesale ที่ท่านต้องการเพิ่มสินค้า</h1>
        <br>
        <a href="{{asset('/tours/wholesale')}}" class="btn btn-success">เลือก Wholesale</a>
     </div>
   </div>

@endsection
