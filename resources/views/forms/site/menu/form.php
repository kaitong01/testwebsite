<?php

$Fn = new Fn;

$formAction = '/site/menu';
$seoBase = '/';

if( !empty($data) ){
    $formAction .= '/'.$data->id;
    if(!empty($data->image)){
      $imageCoverOpt['src'] = asset("storage/{$data->image}");
    }

    if( $lock==1 ){
        $arr['hiddenInput'][] = array('name'=>'type', 'value'=>$data->id);
    }
    else{
        $arr['hiddenInput'][] = array('name'=>'id', 'value'=>$data->id);
        $arr['hiddenInput'][] = array('name'=>'type', 'value'=>$data->type);
    }


    $arr['hiddenInput'][] = array('name'=>'_method', 'value'=>'PUT');

    $arr['title'] = 'แก้ไขหน้าเว็บไซต์';
    $arr['title'] .= !empty($data->name)? ' : '. $data->name:'';
    $arr['title'] .= '<div class="fsm text-muted" style="font-size:13px">แก้ไขล่าสุด: '.$Fn->q('time')->live( $data->updated_at ).'</div>';
}
else{
    $arr['hiddenInput'][] = array('name'=>'_method', 'value'=>'post');
    $arr['title'] = 'เพิ่มหน้าเว็บไซต์ใหม่';
}

$arr['hiddenInput'][] = array('name'=>'_token', 'value'=>csrf_token());


$form = new Form();
$formBasic = $form->create()
    // set From
    ->elem('div')
    ->addClass('form-insert')

 ->field("name")
        ->label( 'หัวเรื่อง* (75 ตัวอักษร)' )
        ->autocomplete('off')
        ->maxlength( 75 )
        ->addClass('form-control input-title')
        ->value( !empty($data->name)? $data->name:'' )

 ->field("description")
        ->type( 'textarea' )
        ->label( 'คำอธิบายแบบย่อ* (320 ตัวอักษร)' )
        ->autocomplete('off')
        ->addClass('form-control input-content')
        ->attr('rows', 2)
        ->maxlength( 320 )
        ->attr('data-plugin', 'autosize')
        ->value( !empty($data->description)? $data->description:'' )

 ->field("content")
        ->type( 'textarea' )
        ->label( 'เนื้อหา*' )
        ->autocomplete('off')
        ->addClass('form-control')
        ->placeholder('')
        ->attr('rows', 10)
        ->attr('data-plugin', 'autosize')
        ->value( !empty($data->content)? $data->content:'' )
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
                '<div class="seourl-base">'.$seoBase.'</div>'.
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
$arr['body'] = '<div data-plugins="formstaps|formseo" class="form-staps row no-gutters">'.
    '<div class="col-12 col-sm-8"><div class="form-staps-content">'.
        '<div data-stap-section="basic" class="form-staps-section active">'.$formBasic.'</div>'.
        '<div data-stap-section="seo" class="form-staps-section">'.$formSEO.'</div>'.
    '</div></div>'.

    '<div class="col-12 col-sm-4 form-staps-tools">'.

        '<ul class="form-staps-tools__nav">'.
            '<li class="nav-item active" data-stap-action="basic">'.
                '<h3>รายละเอียด</h3>'.
                '<p>ใส่รายละเอียดเนื้อหาบนหน้าเว็บ</p>'.
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

if( empty($is_default) ){

    foreach ($statusList as $key => $value) {
        $active = $statusActive==$value['id']? ' selected': '';
        $status .= '<option'.$active.' value="'.$value['id'].'">'.$value['name'].'</option>';
    }

    $status = '<select class="form-control input-group-text" name="status">'.$status.'</select>';
}

# fotter: buttons
$arr['button'] = '<div class="d-flex justify-content-end">'.
    $status.
    '<button type="submit" class="btn btn-primary btn-submit ml-2"><span class="btn-text">บันทึก</span></button>'.
'</div>';

$arr['width'] = 965;


http_response_code(200);
echo json_encode($arr);
