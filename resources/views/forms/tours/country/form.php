<?php

$Fn = new Fn;

$imageCoverOpt = array(
    'name' => 'file1',
    'width' => 300,
    'height' => 175,

    'dropzoneText' => 'รูป',

    'cancelFileName' => 'file1_cancel_file'
);


$formAction = '/tours/countries/';
if(!empty($data->image)){
    $imageCoverOpt['src'] = asset("storage/{$data->image}");
}
elseif(!empty($original['image'])){
    $imageCoverOpt['src'] = asset("storage/{$original['image']}");
}

$arr['hiddenInput'][] = array('name'=>'country_id', 'value'=> !empty($original->id)? $original->id: null );
$arr['hiddenInput'][] = array('name'=>'company_id', 'value'=> Auth::user()->company->id );

$arr['hiddenInput'][] = array('name'=>'_token', 'value'=>csrf_token());
$arr['hiddenInput'][] = array('name'=>'_method', 'value'=>'POST');

if( !empty($data->id) ){
    $arr['hiddenInput'][] = array('name'=>'id', 'value'=> !empty($data->id)? $data->id: null );
}


$originalName = !empty($original['name'])? $original['name']:'';
if( !empty($original['name_th']) ){
    $originalName = $original['name_th'];
}

$arr['title'] = 'ตั้งค่าประเทศ';
$arr['title'] .= !empty($data['name'])? $data['name']: $originalName;

if( !empty($data['updated_at']) ){
    $arr['title'] .= '<div class="fsm text-muted" style="font-size:13px">แก้ไขล่าสุด: '.$Fn->q('time')->live( $data['updated_at'] ).'</div>';
}

$form = new Form();
$formBasic = $form->create()
    // set From
    ->elem('div')
    ->addClass('form-insert')
    ->style('horizontal')

   ->field($imageCoverOpt['name'])
        ->label( $imageCoverOpt['dropzoneText'] )
        ->text( '<div style="width: '. $imageCoverOpt['width'] .'px">'.$Fn->q('form')->imageCover( $imageCoverOpt ).'</div>' )

 ->field("name")
        ->label( 'ชื่อ*' )
        ->autocomplete('off')
        ->addClass('form-control input-title')
        ->maxlength(175)
        ->attr('aria-label', 'required')
        ->value( !empty($data->name)? $data->name:'' )
        ->placeholder( $originalName )

 ->field("description")
        ->type( 'textarea' )
        ->label( 'คำอธิบาย' )
        ->autocomplete('off')
        ->addClass('form-control input-content')
        ->attr('data-plugin', 'autosize')
        ->value( !empty($data->description)? $data->description:'' )
        ->placeholder( !empty($original['description'])? $original['description']:'' )


->html();


$form = new Form();
$formSEO = $form->create()
    // set From
    ->elem('div')
    ->addClass('form-insert')

    ->field("seo_title")
        ->label('ใส่ชื่อเพจที่จะให้แสดงในผลการค้นหาหรือบนแท็บบราวเซอร์ (70 ตัวอักษร)')
        ->addClass('form-control input-seo input-title-seo')
        ->autocomplete("off")
        ->maxlength( 70 )
        ->value( !empty($data['seo_title']) ? $data['seo_title']:'' )


    ->field("seo_description")

        ->label('เพจนี้เกี่ยวกับอะไร เพิ่มคำบรรยายเพจ (320 ตัวอักษร)')
        ->addClass('form-control input-seo input-content-seo')
        ->autocomplete("off")
        ->type('textarea')
        ->maxlength( 320 )
        ->attr('data-plugins', 'autosize')
        ->value( !empty($data['seo_description']) ? $data['seo_description']:'' )


    ->field("permalink")
        ->label('ใส่ URL เพจของคุณ')

        ->text(

            '<div class="seourl-wrap d-flex justify-content-between align-items-center">'.
                '<div class="seourl-base">/tours/countries/</div>'.
                '<div class="seourl-input">'.
                    '<input id="permalink" class="form-control input-seo input-url-seo" autocomplete="off" type="text" name="permalink" value="'.(!empty($data['permalink'])? $data['permalink']:'').'" />'.
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



# body
$arr['body'] = '<div data-plugins="formstaps|formseo" class="form-staps row no-gutters">'.
    '<div class="col-12 col-sm-8"><div class="form-staps-content">'.
        '<div data-stap-section="basic" class="form-staps-section active">'.$formBasic.'</div>'.
        '<div data-stap-section="seo" class="form-staps-section">'.$formSEO.'</div>'.
    '</div></div>'.

    '<div class="col-12 col-sm-4 form-staps-tools">'.

        '<ul class="form-staps-tools__nav">'.
            '<li class="nav-item active" data-stap-action="basic">'.
                '<h3>รายละเอียด</h3>'.
                '<p>ใส่รายละเอียดเนื้อหาเกี่ยวเส้นทาง</p>'.
            '</li>'.

            '<li class="nav-item" data-stap-action="seo">'.
                '<h3>SEO</h3>'.
                '<p>ปรับแต่งเว็บไซต์ให้ติดอันดับบนเครื่องมือการค้นหา</p>'.
            '</li>'.
        '</ul>'.
    '</div>'.
'</div>';;

$arr['form'] = '<form class="model-body-p0" method="post" action="'.asset( $formAction ).'" data-plugin="formSubmit"></form>';


$statusCurr = isset($data['status'])? $data['status']: 1;

$status = '';
$statusList = array();
$statusList[] = array('id'=>1, 'name'=>'ใช้งาน');
$statusList[] = array('id'=>0, 'name'=>'ระงับ');

foreach ($statusList as $key => $value) {
    $active = $statusCurr==$value['id']? ' selected': '';
    $status .= '<option'.$active.' value="'.$value['id'].'">'.$value['name'].'</option>';
}

# fotter: buttons
$arr['button'] = '<div class="d-flex justify-content-end">'.
    '<select class="form-control input-group-text" name="status">'.$status.'</select>'.
    '<button type="submit" class="btn btn-primary btn-submit ml-2"><span class="btn-text">บันทึก</span></button>'.
'</div>';

$arr['width'] = 965;

// return response()->json($arr, 404);

http_response_code(200);
echo json_encode($arr);
