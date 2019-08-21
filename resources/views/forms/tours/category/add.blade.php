<?php

$Fn = new Fn;

$imageCoverOpt = array(
    'name' => 'image',
    'width' => 600,
    'height' => 338,


    'dropzoneText' => 'แนบรูปหน้าปก',
);



if( !empty($item) ){
    $formAction = '/tours/category/'.$item['id'];
    if(!empty($item['image'])){
      $imageCoverOpt['src'] = asset("storage/{$item['image']}");
    }

    $arr['hiddenInput'][] = array('name'=>'id', 'value'=>$item['id']);
    $arr['hiddenInput'][] = array('name'=>'_method', 'value'=>'PUT');
    // $arr['hiddenInput'][] = array('name'=>'_method', 'value'=>'PUT');

    $arr['title'] = 'แก้ไขประเภททัวร์';
    $arr['title'] .= '<div class="fsm text-muted" style="font-size:13px">แก้ไขล่าสุด: '.$Fn->q('time')->live( $item['updated_at'] ).'</div>';
}
else{
    $formAction = '/tours/category';
    $arr['hiddenInput'][] = array('name'=>'_method', 'value'=>'post');
    $arr['title'] = 'เพิ่มประเภททัวร์';
}

$arr['hiddenInput'][] = array('name'=>'_token', 'value'=>csrf_token());





$form = new Form();
$formBasic = $form->create()
    // set From
    ->elem('div')
    ->addClass('form-insert')


   ->field($imageCoverOpt['name'])
        // ->label('รูปภาพ')
        ->text( '<div style="width: 585px">'.$Fn->q('form')->imageCover( $imageCoverOpt ).'</div>' )




       ->html();



!empty($item['start_date'])? $start_date=$item['start_date']:$start_date='';
!empty($item['end_date'])? $end_date=$item['end_date']:$end_date='';

$form = new Form();
$formFill = $form->create()
    // set From
    ->elem('div')
    ->addClass('form-insert')

    ->field("name")
           ->label( 'ชื่อ*' )
           ->autocomplete('off')
           ->addClass('form-control input-title')
           // ->placeholder('')
           ->value( !empty($item['name'])? $item['name']:'' )

           ->field("date")
                  ->text("
                  <div class='row'>
                  <div class='col-12 col-sm-6'>
                  <label style='font-size:12px;'>วันเริ่มต้น*</label>
                  <input name='start_date'  value='".$start_date."' type='text' class='form-control' data-plugin='flatpickr' data-options='".htmlentities(json_encode(['dateFormat'=> 'd/m/Y']))."'>
                  </div>
                  <div class='col-12 col-sm-6'>
                  <label style='font-size:12px;'>วันสิ้นสุด*</label>
                  <input name='end_date'   value='".$end_date."' type='text' class='form-control' data-plugin='flatpickr' data-options='".htmlentities(json_encode(['dateFormat'=> 'd/m/Y']))."'>
                  </div>
                  </div>
                  ")

                  ->field("link")
                      ->label('ใส่ URL เพจของคุณ')

                      ->text(

                          '<div class="seourl-wrap d-flex justify-content-between align-items-center">'.
                              '<div class="seourl-base">/บทความ/</div>'.
                              '<div class="seourl-input">'.
                                  '<input id="link" class="form-control input-seo input-url-seo" autocomplete="off" type="text" name="permalink" value="'.(!empty($item['permalink'])? $item['permalink']:'').'" />'.
                              '</div>'.
                          '</div>'
                      )


    ->hr( '<div class="control-google-preview d-none" ref="preview">'.

        '<div class="header">ดูตัวอย่างบน Google</div>'.
        '<div class="preview">'.

            '<div class="preview-content">'.
                '<div class="title"></div>'.
                '<div class="url"></div>'.
                '<div class="description"></div>'.
            '</div>'.
        '</div>'.

    '</div>' )
->html();



$form = new Form();
$formDetail = $form->create()
    // set From
    ->elem('div')
    ->addClass('form-insert')

        ->field("description")
               ->type( 'textarea' )
               ->label( 'คำอธิบาย*' )
               ->autocomplete('off')
               ->addClass('form-control input-content')
               ->placeholder('อธิบายเส้นทางเพื่อให้ผู้คนรู้ว่ามีเนื้อหาเกี่ยวกับอะไร')
               ->attr('data-plugin', 'autosize')
               ->value( !empty($item['description'])? $item['description']:'' )
       ->html();



# body
$arr['body'] = '<div data-plugin="choose_country">
<div data-plugins="" class="row no-gutters">'.
    '<div class="col-12 col-sm-6"><div class="form-staps-content">'.
        '<div data-stap-section="basic" class="form-staps-section active">'.$formBasic.'</div>'.
    '</div></div>'.

    '<div class="col-12 col-sm-6"><div class="form-staps-content">'.
        '<div data-stap-section="basic" class="form-staps-section active">'.$formFill.'</div>'.
    '</div></div>'.
'</div>'.
'</div>'.
'<div data-plugins="" class="row no-gutters">'.
    '<div class="col-12 col-sm-12"><div class="form-staps-content">'.
        '<div data-stap-section="basic" class="form-staps-section active">'.$formDetail.'</div>'.
    '</div></div>'.
'</div>'.
'</div>'

;

$arr['form'] = '<form class="model-body-p0" method="post" action="'.asset( $formAction ).'" data-plugins="formSubmit"></form>';


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
$arr['button'] = '<div class="d-flex justify-content-end">'.

    '<select class="form-control input-group-text" name="status">'.$status.'</select>'.

    '<button type="submit" class="btn btn-primary btn-submit ml-2"><span class="btn-text">บันทึก</span></button>'.

'</div>';
// $arr['cancel'] = '<button type="button" class="btn btn-sm btn-danger" data-action="close"><span class="btn-text">ยกเลิก</span></button>';
// $arr['close'] = true;
$arr['width'] = '70%';
// $arr['bg'] = 'blue';
// $arr['effect'] = 7;

// return response()->json($arr, 404);

http_response_code(200);
echo json_encode($arr);
