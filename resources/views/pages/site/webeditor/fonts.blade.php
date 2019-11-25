<div class="container-fluid">
  <div class="row" style="padding:20px;">
    <div class="col-12">

      <div class="row">
        <div class="col-12">
          <div class="page-title d-flex justify-content-between ptl">
          		<div>
          			<h3>Fonts </h3>
          		</div>

			   </div>
        </div>
      </div>

      <div class="row" style="margin-top:20px;">
        <div class="col-12">
          <div class="row">
            <div class="col-12">
              <div class="card ">
                  <div class="card-header bg-primary ">
                    <h4>  </h4>
                  </div>
                  <div class="card-body">
                    <div class="row" >
                      @foreach($data as $row)
                      <div class="col-3" style="margin-top:15px">
                        <div class="card ">
                            <div class="card-header  ">
                              <h4>{{$row->name}} </h4>
                            </div>
                            <div class="card-body" style="height:100px">
                              <div class="row">
                                <span style="">{{$row->text}}</span>
                              </div>
                            </div>
                          </div>

                      </div>


                      @endforeach
                    </div>
                  </div>
                </div>

            </div>
          </div>



        </div>

      </div>

    </div>
  </div>


</div>
