<?php

$Fn = new Fn;


    $formAction = '/tours/country';
    $arr['hiddenInput'][] = array('name'=>'_method', 'value'=>'post');
    $arr['title'] = 'เลือกประเทศ';

if( !empty($data) ){
  $arr['hiddenInput'][] = array('name'=>'cid', 'value'=>'');
}

$arr['hiddenInput'][] = array('name'=>'_token', 'value'=>csrf_token());


$form = new Form();



$db = DB::table('country_route')->get();
$Africa = "";
$Asia = "";
$Europe = "";
$North_America = "";
$South_America = "";
$Oceania = "";
$Antarctica = "";

foreach ($db as $row) {
  $flag = strtolower($row->code_flag);

  if($row->category_id =='1'){
  $Africa   .=  '<div style="margin-top:10px;" data-country="'.$row->id.'"  class="col-1">
  <span class="flag-icon flag-icon-'.$flag.'"></span>
  <span>'.$row->name.'</span>
</div>' ;
  }
  if($row->category_id =='2'){
  $Asia   .=  '<div style="margin-top:10px;" data-country="'.$row->id.'"  class="col-1">
  <span class="flag-icon flag-icon-'.$flag.'"></span>
  <span>'.$row->name.'</span>
</div>' ;
  }
  if($row->category_id =='3'){
  $Europe   .=  '<div style="margin-top:10px;" data-country="'.$row->id.'"  class="col-1">
  <span class="flag-icon flag-icon-'.$flag.'"></span>
  <span>'.$row->name.'</span>
</div>' ;
  }
  if($row->category_id =='4'){
  $North_America   .=  '<div style="margin-top:10px;" data-country="'.$row->id.'"  class="col-1">
  <span class="flag-icon flag-icon-'.$flag.'"></span>
  <span>'.$row->name.'</span>
</div>' ;
  }
  if($row->category_id =='5'){
  $South_America   .=  '<div style="margin-top:10px;" data-country="'.$row->id.'"  class="col-1">
  <span class="flag-icon flag-icon-'.$flag.'"></span>
  <span>'.$row->name.'</span>
</div>' ;
  }
  if($row->category_id =='6'){
  $Oceania   .=  '<div style="margin-top:10px;" data-country="'.$row->id.'"  class="col-1">
  <span class="flag-icon flag-icon-'.$flag.'"></span>
  <span>'.$row->name.'</span>
</div>' ;
  }

  if($row->category_id =='7'){
  $Antarctica   .= '<div style="margin-top:10px;" data-country="'.$row->id.'"  class="col-1">
  <span class="flag-icon flag-icon-'.$flag.'"></span>
  <span>'.$row->name.'</span>
</div>' ;
  }


}

$formLocation = $form->create()
    // set From
    ->elem('div')
    ->addClass('form-insert')
 ->field("country_id")

        ->label( 'ประเทศ' )
        ->text("<input type='hidden' name='country_id'>
        <div class='row show-country' style='padding:30px;'> </div>")


 ->field("Asia")
        ->text("
        <div class='row' style='overflow-y: scroll;height: 600px;position: relative;'>
        <div class='col-12'>

        <div class='row'>
        <div class='col-12'><h4>Asia</h4></div>
        </div>
        <hr class='my-4'>
        <div class='row'>
        <div class='btn-toolbar' role='toolbar' aria-label='Toolbar with button groups'>".$Asia."</div>
        </div>
        <hr class='my-4'>
        <div class='row'>
        <div class='col-12'><h4>Europe</h4></div>
        </div>
        <hr class='my-4'>
        <div class='row'>
        <div class='btn-toolbar' role='toolbar' aria-label='Toolbar with button groups'>".$Europe."</div>
        </div>
        <hr class='my-4'>
        <div class='row'>
        <div class='col-12'><h4>North America</h4></div>
        </div>
        <hr class='my-4'>
        <div class='row'>
        <div class='btn-toolbar' role='toolbar' aria-label='Toolbar with button groups'>".$North_America."</div>
        </div>
        <hr class='my-4'>

        <div class='row'>
        <div class='col-12'><h4>South America</h4></div>
        </div>
        <hr class='my-4'>
        <div class='row'>
        <div class='btn-toolbar' role='toolbar' aria-label='Toolbar with button groups'>".$South_America."</div>
        </div>
        <hr class='my-4'>

        <div class='row'>
        <div class='col-12'><h4>Africa</h4></div>
        </div>
        <hr class='my-4'>
        <div class='row'>
        <div class='btn-toolbar' role='toolbar' aria-label='Toolbar with button groups'>".$Africa."</div>
        </div>
        <hr class='my-4'>




        </div>
        </div>
        ")


->html();








# body
$arr['body'] = '<div data-plugin="choose_country " data-options="'.$Fn->_stringify([
    'data' => isset( $item['country'] )? json_decode($item['country'],1): [],

    'token' => csrf_token(),
]).'">
<div class="row">'.
    '<div class="col-12 col-sm-12">'.$formLocation.
    '</div>'.
'</div>';

$arr['form'] = '<form class="" method="post" action="'.asset( $formAction ).'" data-plugins="formSubmit"></form>';


$statusCurr = !empty($item['status'])? $item['status']: 1;

$status = '';
$statusList = array();
$statusList[] = array('id'=>1, 'name'=>'ใช้งาน');
$statusList[] = array('id'=>2, 'name'=>'ระงับ');

foreach ($statusList as $key => $value) {
    $active = $statusCurr==$value['id']? ' selected': '';
    $status .= '<option'.$active.' value="'.$value['id'].'">'.$value['name'].'</option>';
}

# fotter: buttons
$arr['button'] = '<div class="text-center">'.
    '<button type="submit" class="btn btn-primary btn-submit ml-2"><span class="btn-text">บันทึก</span></button>'.
'</div>';
// $arr['cancel'] = '<button type="button" class="btn btn-sm btn-danger" data-action="close"><span class="btn-text">ยกเลิก</span></button>';
// $arr['close'] = true;
$arr['width'] = '100%';

// $arr['bg'] = 'blue';
// $arr['effect'] = 7;

// return response()->json($arr, 404);

http_response_code(200);
echo json_encode($arr);
