<?php

$Fn = new Fn;

$imageCoverOpt = array(
    'name' => 'image',
    'width' => 600,
    'height' => 338,


    'dropzoneText' => 'แนบรูปหน้าปก',
);



if( !empty($item) ){
    $formAction = '/blogs/add/'.$item['id'];
    if(!empty($item['image'])){
      $imageCoverOpt['src'] = asset("storage/{$item['image']}");
    }

    $arr['hiddenInput'][] = array('name'=>'id', 'value'=>$item['id']);
    $arr['hiddenInput'][] = array('name'=>'_method', 'value'=>'PUT');
    // $arr['hiddenInput'][] = array('name'=>'_method', 'value'=>'PUT');

    $arr['title'] = 'แก้ไขบทความ';
    $arr['title'] .= '<div class="fsm text-muted" style="font-size:13px">แก้ไขล่าสุด: '.$Fn->q('time')->live( $item['updated_at'] ).'</div>';
}
else{
    $formAction = '/blogs/add';
    $arr['hiddenInput'][] = array('name'=>'_method', 'value'=>'post');
    $arr['title'] = 'เพิ่มบทความ';
}

$arr['hiddenInput'][] = array('name'=>'_token', 'value'=>csrf_token());



!empty($item['start_date'])? $start_date=$Fn->q('date')->convertDateTo_th( $item['start_date'] ):$start_date='';
!empty($item['end_date'])? $end_date=$Fn->q('date')->convertDateTo_th( $item['end_date'] ):$end_date='';

$form = new Form();
$formBasic = $form->create()
    // set From
    ->elem('div')
    ->addClass('form-insert')

    ->field("name")
           ->label( 'ชื่อบทความ' )
           ->autocomplete('off')
           ->addClass('form-control input-title')
           // ->placeholder('')
           ->value( !empty($item['name'])? $item['name']:'' )



        ->field($imageCoverOpt['name'])

             ->text( '<div style="">'.$Fn->q('form')->imageCover( $imageCoverOpt ).'</div>' )

            ->field("category_id")
               ->label( 'ประเภทบทความ' )
              ->text( '<div style="">'.$Fn->q('form')->select_category_blogs().'</div>' )

 ->field("highlight")
        ->type( 'textarea' )
        ->label( 'ไฮไลท์บทความ' )
        ->autocomplete('off')
        ->addClass('form-control input-content')
        // ->placeholder('อธิบายเส้นทางเพื่อให้ผู้คนรู้ว่ามีเนื้อหาเกี่ยวกับอะไร')
        ->attr('data-plugin', 'autosize')
        ->value( !empty($item['highlight'])? $item['highlight']:'' )

        ->field("permalink")
            ->label('ใส่ URL เพจของคุณ')

            ->text(

                '<div class="seourl-wrap d-flex justify-content-between align-items-center">'.
                    '<div class="seourl-base">/บทความ/</div>'.
                    '<div class="seourl-input">'.
                        '<input id="permalink" class="form-control input-seo input-url-seo" autocomplete="off" type="text" name="permalink" value="'.(!empty($item['permalink'])? $item['permalink']:'').'" />'.
                    '</div>'.
                '</div>'
            )

        ->field("author")
               ->label( 'ผู้เขียน' )
               ->autocomplete('off')
               ->addClass('form-control input-title')
               // ->placeholder('')
               ->value( !empty($item['author'])? $item['author']:'' )

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



->html();

$form = new Form();
$formArticle = $form->create()
    // set From
    ->elem('div')
    ->addClass('form-insert')

    ->field("text")
        ->label('รายละเอียดบทความ')
        ->addClass('form-control input-seo input-content-seo')
        ->autocomplete("off")
        ->type('textarea')
        ->attr('rows',20)
        ->attr('data-plugins', 'autosize')
        ->value( !empty($item['text']) ? $item['text']:'' )
            ->field("seo_title")
                ->label('ใส่ชื่อเพจที่จะให้แสดงในผลการค้นหาหรือบนแท็บบราวเซอร์ (70 ตัวอักษร)')
                ->addClass('form-control input-seo input-title-seo')
                ->autocomplete("off")
                ->maxlength( 70 )
                ->value( !empty($item['seo_title']) ? $item['seo_title']:'' )

            ->field("seo_description")
                ->label('เพจนี้เกี่ยวกับอะไร เพิ่มคำบรรยายเพจ (320 ตัวอักษร)')
                ->addClass('form-control input-seo input-content-seo')
                ->autocomplete("off")
                ->type('textarea')
                ->maxlength( 320 )
                ->attr('data-plugins', 'autosize')
                ->value( !empty($item['seo_description']) ? $item['seo_description']:'' )





->html();


// $form = new Form();
// $formSEO = $form->create()
//     // set From
//     ->elem('div')
//     ->addClass('form-insert')
//
//     ->field("seo_title")
//         ->label('ใส่ชื่อเพจที่จะให้แสดงในผลการค้นหาหรือบนแท็บบราวเซอร์ (70 ตัวอักษร)')
//         ->addClass('form-control input-seo input-title-seo')
//         ->autocomplete("off")
//         ->maxlength( 70 )
//         ->value( !empty($item['seo_title']) ? $item['seo_title']:'' )
//
//     ->field("seo_description")
//         ->label('เพจนี้เกี่ยวกับอะไร เพิ่มคำบรรยายเพจ (320 ตัวอักษร)')
//         ->addClass('form-control input-seo input-content-seo')
//         ->autocomplete("off")
//         ->type('textarea')
//         ->maxlength( 320 )
//         ->attr('data-plugins', 'autosize')
//         ->value( !empty($item['seo_description']) ? $item['seo_description']:'' )
//
//     ->field("permalink")
//         ->label('ใส่ URL เพจของคุณ')
//
//         ->text(
//
//             '<div class="seourl-wrap d-flex justify-content-between align-items-center">'.
//                 '<div class="seourl-base">/บทความ/</div>'.
//                 '<div class="seourl-input">'.
//                     '<input id="permalink" class="form-control input-seo input-url-seo" autocomplete="off" type="text" name="permalink" value="'.(!empty($item['permalink'])? $item['permalink']:'').'" />'.
//                 '</div>'.
//             '</div>'
//         )
//
//     ->hr( '<div class="control-google-preview d-none" ref="preview">'.
//
//         '<div class="header">ดูตัวอย่างบน Google</div>'.
//         '<div class="preview">'.
//
//             '<div class="preview-content">'.
//                 '<div class="title"></div>'.
//                 '<div class="url"></div>'.
//                 '<div class="description"></div>'.
//             '</div>'.
//         '</div>'.
//
//     '</div>' )
// ->html();



# body
$arr['body'] = '<div data-plugins="formstaps|formseo" class="form-staps row no-gutters">'.
    '<div class="col-12 col-sm-8"><div class="form-staps-content">'.
        '<div data-stap-section="basic" class="form-staps-section active">'.$formBasic.'</div>'.
        '<div data-stap-section="article" class="form-staps-section">'.$formArticle.'</div>'.

    '</div></div>'.

    '<div class="col-12 col-sm-4 form-staps-tools">'.
        // '<div class="form-staps-tools__header"></div>'.

        '<ul class="form-staps-tools__nav">'.
            '<li class="nav-item active" data-stap-action="basic">'.
                '<h3>หัวข้อ รูป และ ลิ้งค์ของบทความ</h3>'.
                '<p>ใส่รายละเอียดเกี่ยวกับ</p>'.
            '</li>'.

            '<li class="nav-item" data-stap-action="article">'.
                '<h3>รายละเอียดบทความ</h3>'.
                '<p>ใส่รายละเอียดเกี่ยวกับบทความ</p>'.
            '</li>'.

            // '<li class="nav-item" data-stap-action="seo">'.
            //     '<h3>SEO</h3>'.
            //     '<p>ปรับแต่งเว็บไซต์ให้ติดอันดับบนเครื่องมือการค้นหา</p>'.
            // '</li>'.
        '</ul>'.
    '</div>'.

'</div>';

$arr['form'] = '<form class="model-body-p0" method="post" action="'.asset( $formAction ).'" data-plugin="formSubmit"></form>';


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
$arr['width'] = '60%';
// $arr['bg'] = 'blue';
// $arr['effect'] = 7;

// return response()->json($arr, 404);

http_response_code(200);
echo json_encode($arr);
