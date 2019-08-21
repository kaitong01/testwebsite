<div class="container-fluid" style="padding:50px;">
  <div class="row">
      <div class="col-12">
          <h4>ประเทศ</h4>

      </div>
  </div>
  <hr  style="margin:5px;">
  <div class="row">
      <div class="col-12">
          <h6>เลือกประเทศที่คุณทำการขาย</h6>

      </div>
  </div>
  <div class="row" style="margin-top:30px;">
      <div class="col-12 text-center">

        <a class="btn btn-primary" href="/tours/country/create" data-plugin="lightbox"  style="width:150px;"> <span>เลือกประเทศ</span></a>
      </div>
  </div>

  <div class="row" style="margin-top:30px;">
      <div class="col-12">
          <span style="font-weight:bold;font-size:18px;">ประเทศที่เลือก</span>

      </div>
  </div>

  <div class="row" style="margin-top:30px;">
      <div class='col-12 btn-toolbar' role='toolbar' aria-label='Toolbar with button groups'>

        @if($data!==null)


        @foreach($data as $key => $row)
        <?php
        $flag = strtolower($data[$key]->code_flag);
        ?>
        <div style="margin-top:10px;"  class="col-1">
        <span class="flag-icon flag-icon-{{$flag}}"></span>
        <span>{{$data[$key]->name}}</span>
      </div>
        @endforeach
        @endif

      </div>

  </div>

</div>
