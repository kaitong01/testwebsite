@extends('layouts.admin')

@section('title', '')

@section('content')
<style type="text/css">
  td{
    padding: 15px;
  }
</style>
<body style="background-color:#f2f2f2;">
  <div class="container">
  <div class="row" id="row1" style="padding:20px;">
    <div class="col-lg-12 col-md-12 col-sm-12">

      <div class="row">
        <div class="col-12">
          <div class="page-title d-flex justify-content-between ptl">
            <div>
             <h3>หน้าเว็บไซต์ <span class="fsm fcg fwn">4/5</span></h3>
           </div>
           <a href="" class="btn btn-sm btn-primary">+ Page</a>
         </div>
       </div>
     </div>

     <div class="row" style="margin-top:15px;">
      <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="alert alert-warning " role="alert">
          <p class="fwb">คุณสามารถ เพิ่มหน้าใหม่ได้ไม่เกิน 5 หน้า</p>
        </div>

          <table class="table table-sm" cellpadding="10" width="100%" style="background-color: white; border-radius: 10px;">
            <div class="container table-responsive" style="border-radius: 10px; background-color: white;">
            <thead class="" >
              <tr class=" " style="font-size: 13px; color: #8d949e" >
                <th scope="col" width="5%"></th>
                <th scope="col" class="" width="60%">หน้าเว็บไซต์</th>
                <th scope="col" class="text-center" width="10%">ประเภท</th>
                <th scope="col" class="text-center" width="10%">สถานะ</th>
                <th scope="col" class="text-center" width="5%"></th>
                <th scope="col" class="text-center" width="5%"></th>
              </tr>
            </thead>
            <tbody>
             @foreach($data as $key => $value)
             <tr>

              <td style="padding-top: 15px;"></td>
              <td style="padding-top: 15px;">
                <div class="" >
                 <a href="" style="color:#3b5998;">{{$value->name}}</a>
               </div>
               <div class="" >
                <p style="color: #888; font-size: 15px;">{{$value->title}}</p>
              </div>
            </td>
            @if($value->type == 2)
            <td class="text-center" style="padding: 15px;"><span class="badge badge-pill badge-success text-white" style="padding: 5px; padding-right: 10px; padding-left: 10px; width: 100px;">CUSTOM PAGE</span></td>
            @else
            <td class="text-center" style="padding: 15px;"><span class="badge badge-pill badge-warning text-dark" style="padding: 5px; width: 100px;">STATIC PAGE</span></td>
            @endif

            @if($value->status == 1)
            <td class="text-center" style="padding: 15px;"><span class="badge badge-pill badge-primary text-white" style="padding: 5px; width: 70px;" >ใช้งาน</span></td>
            @else
            <td class="text-center" style="padding: 15px;"><span class="badge badge-pill badge-danger text-white" style="padding: 5px; width: 70px;">ระงับ</span></td>
            @endif

            @if($value->type == 0)
            <td class="text-center" style="padding: 15px;"><button type="button" class="btn btn-light" style="width: 70px;">แก้ไข</button></td>
            @else
            <td class="text-center" style="padding: 15px;"><button type="button" class="btn btn-light" style="width: 70px;">แก้ไข</button></td>
            <td style="padding: 15px;" ><button type="button" class="btn btn-light" style="width: 70px;">ลบ</button></td>
            @endif



          </tr>
          @endforeach
        </tbody>
        </div>
      </table>

  </div>
</div>

</div>
</div>


</div>
</body>
@endsection
