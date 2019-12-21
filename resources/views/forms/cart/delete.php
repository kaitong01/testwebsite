<?php

$arr['title'] = 'ยกเลิกข้อมูล';

$arr['form'] = '<form  method="post" action="'.asset( '/carts/'.$data->id ).'" data-plugin="formSubmit"></form>';
$arr['hiddenInput'][] = array('name'=>'id','value'=>$data->id);
$arr['hiddenInput'][] = array('name'=>'_method','value'=>'delete');
$arr['hiddenInput'][] = array('name'=>'_token', 'value'=>csrf_token());

$arr['body'] = '<div>หากคุณยกเลิกข้อมูลนี้:</div>';
$arr['body'] .= '<ul class="uiListStandard">';
$arr['body'] .= "<li>ข้อมูลนี้จะถูกย้ายไปที่สถานะยกเลิกข้อมูล</li>";
$arr['body'] .= "<li>ข้อมูลนี้สามารถนำกลับมาใช้งานได้อีก</li>";
$arr['body'] .= '</ul>';

$arr['body'] .= '<div class="mt-3 d-flex align-items-center"><svg width="16" height="16" viewBox="0 0 24 24"><path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z" fill="#f4b400"></path></svg><span class="ml-2">คุณแน่ใจที่จะยกเลิกข้อมูลนี้ใช่ไหม?</span></div> ';

$arr['button'] = [
    '<button type="submit" class="btn btn-danger btn-submit ml-2"><span class="btn-text">ยกเลิกข้อมูล</span></button>',
    '<button type="button" class="btn btn-outline-secondary ml-2" data-action="close"><span class="btn-text">ปิด</span></button>'
];

$arr['bottom_msg'] = '<label class="checkbox"><input type="checkbox" name="confirm" value="1" aria-label="required"><span class="ml-2">ตกลง ฉันเข้าใจ</span></label>';


$arr['bg'] = 'red';
$arr['close'] = true;

http_response_code(200);
echo json_encode($arr);
