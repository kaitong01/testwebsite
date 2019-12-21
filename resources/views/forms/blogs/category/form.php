<?php

$Fn = new Fn;

$imageCoverOpt = array(
    'name' => 'image',
    'width' => 600,
    'height' => 338,

    'dropzoneText' => 'แนบรูปหน้าปก',

    'cancelFileName' => 'image_cancel_file',
);

if( !empty($data) ){
    $formAction = '/blogs/categories/'.$data->id;
    if(!empty($data->image)){
      $imageCoverOpt['src'] = asset("storage/{$data->image}");
    }

    $arr['hiddenInput'][] = array('name'=>'id', 'value'=>$data->id);
    $arr['hiddenInput'][] = array('name'=>'_method', 'value'=>'PUT');
    // $arr['hiddenInput'][] = array('name'=>'_method', 'value'=>'PUT');

    $arr['title'] = 'แก้ไขประเภทบทความ';
    $arr['title'] .= !empty($data->name)? $data->name:'';
    $arr['title'] .= '<div class="fsm text-muted" style="font-size:13px">แก้ไขล่าสุด: '.$Fn->q('time')->live( $data->updated_at ).'</div>';
}
else{
    $formAction = '/blogs/categories';
    $arr['hiddenInput'][] = array('name'=>'_method', 'value'=>'post');
    $arr['title'] = 'เพิ่มประเภทบทความ';
}

$arr['hiddenInput'][] = array('name'=>'_token', 'value'=>csrf_token());
$arr['hiddenInput'][] = array('name'=>'company_id', 'value'=> Auth::user()->company->id );



$form = new Form();
$formBasic = $form->create()
    // set From
    ->elem('div')
    ->addClass('form-insert')


   ->field($imageCoverOpt['name'])
        ->text( '<div style="width: 585px">'.$Fn->q('form')->imageCover( $imageCoverOpt ).'</div>' )

 ->field("name")
        ->label( 'ชื่อ*' )
        ->autocomplete('off')
        ->addClass('form-control input-title')
        ->value( !empty($data->name)? $data->name:'' )

 ->field("description")
        ->type( 'textarea' )
        ->label( 'คำอธิบาย*' )
        ->autocomplete('off')
        ->addClass('form-control input-content')
        ->placeholder('')
        ->attr('data-plugin', 'autosize')
        ->value( !empty($data->description)? $data->description:'' )
->html();
// อธิบายเประเภเพื่อให้ผู้คนรู้ว่ามีเนื้อหาเกี่ยวกับอะไร





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
        ->value( !empty($data->seo_title) ? $data->seo_title:'' )


    ->field("seo_description")

        ->label('เพจนี้เกี่ยวกับอะไร เพิ่มคำบรรยายเพจ (320 ตัวอักษร)')
        ->addClass('form-control input-seo input-content-seo')
        ->autocomplete("off")
        ->type('textarea')
        ->maxlength( 320 )
        ->attr('data-plugins', 'autosize')
        ->value( !empty($data->seo_description) ? $data->seo_description:'' )


    ->field("permalink")
        ->label('ใส่ URL เพจของคุณ')

        ->text(

            '<div class="seourl-wrap d-flex justify-content-between align-items-center">'.
                '<div class="seourl-base">/blogs/categories/</div>'.
                '<div class="seourl-input">'.
                    '<input id="permalink" class="form-control input-seo input-url-seo" autocomplete="off" type="text" name="permalink" value="'.(!empty($data->permalink)? $data->permalink:'').'" />'.
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
$arr['body'] = '<div data-plugins="formstaps|formseo|ChooseCountry" class="form-staps row no-gutters">'.
    '<div class="col-12 col-sm-8"><div class="form-staps-content">'.
        '<div data-stap-section="basic" class="form-staps-section active">'.$formBasic.'</div>'.
        '<div data-stap-section="seo" class="form-staps-section">'.$formSEO.'</div>'.
    '</div></div>'.

    '<div class="col-12 col-sm-4 form-staps-tools">'.
        // '<div class="form-staps-tools__header"></div>'.

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
'</div>';

$arr['form'] = '<form class="model-body-p0" method="post" action="'.asset( $formAction ).'" data-plugins="formSubmit"></form>';


$statusActive = !empty($data['status'])? $data['status']: 1;

$status = '';

foreach ($statusList as $key => $value) {
    $active = $statusActive==$value['id']? ' selected': '';
    $status .= '<option'.$active.' value="'.$value['id'].'">'.$value['name'].'</option>';
}

# fotter: buttons
$arr['button'] = '<div class="d-flex justify-content-end">'.

    '<select class="form-control input-group-text" name="status">'.$status.'</select>'.

    '<button type="submit" class="btn btn-primary btn-submit ml-2"><span class="btn-text">บันทึก</span></button>'.

'</div>';
// $arr['cancel'] = '<button type="button" class="btn btn-sm btn-danger" data-action="close"><span class="btn-text">ยกเลิก</span></button>';
// $arr['close'] = true;
$arr['width'] = 965;
// $arr['bg'] = 'blue';
// $arr['effect'] = 7;

// return response()->json($arr, 404);

http_response_code(200);
echo json_encode($arr);
