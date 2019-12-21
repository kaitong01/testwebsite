<div class="container-fluid" style="padding:50px;">
  <div class="row">
      <div class="col-12">
          <h4>โฮลเซลล์</h4>

      </div>
  </div>
  <hr  style="margin:5px;">
  <div class="row">
      <div class="col-12">
          <h6>เลือกโฮลเซลล์ที่คุณต้องการนำโปรแกรมมาขาย</h6>

      </div>
  </div>
  <div class="row" style="margin-top:30px;">
      <div class="col-12 text-center">

        <a class="btn btn-primary" href="/tours/wholesale/create" data-plugin="lightbox"  style="width:150px;"> <span>เลือกโฮลเซลล์</span></a>
      </div>
  </div>

  <div class="row" style="margin-top:30px;">
      <div class="col-12">
          <span style="font-weight:bold;font-size:18px;">โฮลเซลล์ที่เลือก</span>

      </div>
  </div>

  <div class="row" style="margin-top:30px;">
      <div class='col-12 btn-toolbar' role='toolbar' aria-label='Toolbar with button groups'>
        @if($data!==null)


        @foreach($data as $row)
        <div style="margin-top:10px;" data-wholesale="{{$row->id}}"  class="col-3" >
        <svg height="50" width="50">
        <circle cx="25" cy="25" r="20" stroke="" stroke-width="3" fill="#2680EB" />
      </svg>
        <span>{{$row->name}}</span>
      </div>
        @endforeach
        @endif

      </div>

  </div>

</div>
