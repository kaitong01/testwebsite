<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container-fluid">
  <div class="card-body" data-plugin="page_fonts">
    <input type="hidden" class="font-id" value="{!! $data->co_font !!}">
    <div class="row">
      @foreach( $forntLists as $key => $value )
      <div class="col-xl-4 col-md-6 col-sm-12 fonts-margin {{ $data->co_font==$value->id ? ' font-active':'' }}">
        <div class="card-body card-fonts font-module">
          <div class="custom-control custom-radio ">
            <input type="radio" class="custom-control-input radio-fonts" name="id" value="{{$value->id}}" {{ $data->co_font==$value->id ? ' checked="1"':'' }}>
            <label class="custom-control-label">{{$value->name}}</label>
          </div>
          <hr>
          <p style="font-family:{{$value->style}};font-size: 20px;">{{$value->text}}</p>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>
