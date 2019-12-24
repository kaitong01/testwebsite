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
    $formAction = '/blogs/'.$data->id;
    if(!empty($data->image)){
      $imageCoverOpt['src'] = asset("storage/{$data->image}");
    }

    $arr['hiddenInput'][] = array('name'=>'id', 'value'=>$data->id);
    $arr['hiddenInput'][] = array('name'=>'_method', 'value'=>'PUT');
    // $arr['hiddenInput'][] = array('name'=>'_method', 'value'=>'PUT');

    $arr['title'] = 'แก้ไขบทความ';
    $arr['title'] .= !empty($data->name)? $data->name:'';
    $arr['title'] .= '<div class="fsm text-muted" style="font-size:13px">แก้ไขล่าสุด: '.$Fn->q('time')->live( $data->updated_at ).'</div>';
}
else{
    $formAction = '/blogs';
    $arr['hiddenInput'][] = array('name'=>'_method', 'value'=>'post');
    $arr['title'] = 'เพิ่มบทความ';
}

$arr['hiddenInput'][] = array('name'=>'_token', 'value'=>csrf_token());


$form = new Form();
$formBasic = $form->create()
    // set From
    ->elem('div')
    ->addClass('form-insert')

   ->field($imageCoverOpt['name'])
        ->text( '<div style="width: 603px">'.$Fn->q('form')->imageCover( $imageCoverOpt ).'</div>' )

    ->field("category_id")
        ->label( 'ประเภทบทความ*' )
        ->autocomplete('off')
        ->addClass('form-control')
        ->select( $categoryList )
        ->attr('aria-label', 'required')
        ->value( $data->category_id ?? '' )

    ->field("name")
        ->label( 'หัวข้อ* (200 ตัวอักษร)' )
        ->autocomplete('off')
        ->addClass('form-control input-title')
        ->placeholder('เพิ่มหัวข้อของบทความ...')
        ->attr('aria-label', 'required')
        ->value( $data->name ?? '' )

        ->field("summary")
        ->type( 'textarea' )
        ->label( 'คำอธิบายแบบย่อ* (320 ตัวอักษร)' )
        ->autocomplete('off')
        ->addClass('form-control input-content')
        ->attr('data-plugin', 'autosize')
        ->placeholder('อธิบายบทความของคุณแบบย่อ...')
        ->attr('aria-label', 'required')
        ->value( $data->summary ?? '' )

 ->field("text")
        ->type( 'textarea' )
        ->label( 'คำอธิบายแบบเต็ม*' )
        ->autocomplete('off')
        ->addClass('form-control')
        ->placeholder('อธิบายบทความของคุณเพื่อให้ผู้คนรู้ว่ามีเนื้อหาเกี่ยวกับอะไร')
        ->attr('data-plugin', 'autosize')
        ->attr('rows', 8)
        ->attr('aria-label', 'required')
        ->value( $data->text ?? '' )
->html();
// อธิบายเประเภเพื่อให้ผู้คนรู้ว่ามีเนื้อหาเกี่ยวกับอะไร


$form = new Form();
$formSEO = $form->create()
    // set From
    ->elem('div')
    ->addClass('form-insert')

    ->hr('<div class="alert alert-warning">SEO คือวิธีที่คุณจะปรับแต่งเว็บไซต์ของคุณให้เหมาะสมที่สุด เพื่อจะให้เว็บไซต์ของคุณถูกค้นหาและติดอันดับโดยเสิร์ชเอนจินเช่น Google และอื่น ๆ ได้ง่าย</div>')

    ->field("seo_title")
        ->label('ใส่ชื่อเพจที่จะให้แสดงในผลการค้นหาหรือบนแท็บบราวเซอร์ (70 ตัวอักษร)')
        ->addClass('form-control input-seo input-title-seo')
        ->autocomplete("off")
        ->maxlength( 70 )
        ->value( $data->seo_title ?? '' )


    ->field("seo_description")

        ->label('เพจนี้เกี่ยวกับอะไร เพิ่มคำบรรยายเพจ (320 ตัวอักษร)')
        ->addClass('form-control input-seo input-content-seo')
        ->autocomplete("off")
        ->type('textarea')
        ->maxlength( 320 )
        ->attr('data-plugins', 'autosize')
        ->value( $data->seo_description ?? '' )


    ->field("permalink")
        ->label('ใส่ URL เพจของคุณ')

        ->text(

            '<div class="seourl-wrap d-flex justify-content-between align-items-center">'.
                '<div class="seourl-base">/blogs/</div>'.
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


$formCogs = '';

# body
$arr['body'] = '<div data-plugins="formstaps|formseo|ChooseCountry" class="form-staps row no-gutters">'.
    '<div class="col-12 col-sm-8"><div class="form-staps-content">'.
        '<div data-stap-section="basic" class="form-staps-section active">'.$formBasic.'</div>'.
        '<div data-stap-section="cogs" class="form-staps-section">'.$formCogs.'</div>'.
        '<div data-stap-section="seo" class="form-staps-section">'.$formSEO.'</div>'.
    '</div></div>'.

    '<div class="col-12 col-sm-4 form-staps-tools">'.
        // '<div class="form-staps-tools__header"></div>'.

        '<ul class="form-staps-tools__nav">'.
            '<li class="nav-item active" data-stap-action="basic">'.
                '<h3>รายละเอียด</h3>'.
                '<p>ใส่รายละเอียดเนื้อหาเกี่ยวเส้นทาง</p>'.
            '</li>'.

            '<li class="nav-item" data-stap-action="cogs">'.
                '<h3>ตัวเลือกการเผยแพร่</h3>'.
                '<p>ตั้งค่าก่อนเผยแพร่</p>'.
            '</li>'.

            '<li class="nav-item" data-stap-action="seo">'.
                '<h3>SEO</h3>'.
                '<p>ปรับแต่งเว็บไซต์ให้ติดอันดับบนเครื่องมือการค้นหา</p>'.
            '</li>'.
        '</ul>'.
    '</div>'.
'</div>';

$arr['form'] = '<form class="model-body-p0" method="post" action="'.asset( $formAction ).'" data-plugins="formSubmit"></form>';


$statusActive = $data->status ?? 1;

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
