<?php

$Fn = new Fn;


    $formAction = '/tours/wholesale';
    $arr['hiddenInput'][] = array('name'=>'_method', 'value'=>'post');
    $arr['title'] = 'เลือกโฮลเซลล์';

    $db = DB::table('tour_wholesale')
    ->where('cid','=',Session::get('cid'))
    ->first();

if($db!=null){
  $cid = Session::get('cid');
  $arr['hiddenInput'][] = array('name'=>'cid', 'value'=>$cid);
  $senddata = $db->wholesale;
}






$arr['hiddenInput'][] = array('name'=>'_token', 'value'=>csrf_token());


$form = new Form();



$db = DB::table('wholesales')->get();
$wholesale = "";

foreach ($db as $row) {
  $wholesale   .=  '<div style="margin-top:10px;" data-wholesale="'.$row->id.'"  class="col-2" >
  <svg height="50" width="50">
  <circle cx="25" cy="25" r="20" stroke="" stroke-width="3" fill="#2680EB" />
</svg>
  <span>'.$row->name.'</span>
</div>' ;

}

$formLocation = $form->create()
    // set From
    ->elem('div')
    ->addClass('form-insert')
 ->field("country_id")

        ->label( 'โฮลเซลล์' )
        ->text("<input type='hidden' name='country_id'>
        <div class='row show-wholesale' style='padding:30px;'> </div>")


 ->field("Asia")
        ->text("
        <div class='row' style='overflow-y: scroll;height: 600px;position: relative;'>
        <div class='col-12'>

        <div class='row'>
        <div class='col-12'><h4>Asia</h4></div>
        </div>
        <hr class='my-4'>
        <div class='row'>
        <div class='btn-toolbar' role='toolbar' aria-label='Toolbar with button groups'>".$wholesale."</div>
        </div>

        </div>
        ")


->html();








# body
$arr['body'] = '<div data-plugin="choose_wholesale " data-options="'.$Fn->_stringify([
    'data' => isset( $senddata )? json_decode($senddata,1): [],

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
