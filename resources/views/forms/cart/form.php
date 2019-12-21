<?php



$tabs = [];
$tabs[] = array('id'=>'basic', 'title'=>'ข้อมูลเบื้องต้น', 'subtitle'=>'รายละเอียดเนื้อหาเกี่ยวซีรีย์ทัวร์');
$tabs[] = array('id'=>'plans', 'title'=>'โปรแกรมเดินทาง', 'subtitle'=>'กรอกรายละเอียดแผนการเดินทาง');

$tabs[] = array('id'=>'hotels', 'title'=>'โรงแรมและที่พัก', 'subtitle'=>'กรอกรายละเอียดที่พัก โรงแรม');
$tabs[] = array('id'=>'meals', 'title'=>'มื้ออาหาร', 'subtitle'=>'กรอกรายละเอียดมืออาหาร');

$tabs[] = array('id'=>'period', 'title'=>'พีเรียดเดินทาง', 'subtitle'=>'กำหนดวันที่เดินทางและราคา');
$tabs[] = array('id'=>'gallery', 'title'=>'รูปภาพ', 'subtitle'=>'อัปโหลดรูปภาพประกอบ');
$tabs[] = array('id'=>'docs', 'title'=>'ไฟล์', 'subtitle'=>'อัปโหลดไฟล์เอกสาร Word และ PDF');
$tabs[] = array('id'=>'conditions', 'title'=>'เงื่อนไข', 'subtitle'=>'ข้อจำกัดหรือหมายเหตุ สำหรับการท่องเที่ยวหรือการจอง');
$tabs[] = array('id'=>'seo', 'title'=>'SEO', 'subtitle'=>'ปรับแต่งทัวร์คุณให้ติดอันดับบนเครื่องมือการค้นหา');


$tab = '';
foreach ($tabs as $key => $value) {


    $tab .= '<li class="nav-item'.($key==0? ' active':'').'" data-stap-action="'. $value['id'] .'">'.
        '<h3>'. $value['title'] .'</h3>'.
        '<p>'. $value['subtitle'] .'</p>'.
    '</li>';
}


$Fn = new Fn;

$arr['hiddenInput'][] = array('name'=>'_token', 'value'=>csrf_token());
$arr['hiddenInput'][] = array('name'=>'_method', 'value'=>'PUT');
$arr['hiddenInput'][] = array('name'=>'wholesale_id', 'value'=> $data->serie->wholesale->id );

$arr['title'] = '<h3 class="mb-3 fs-18 fwb">ยืนยันการนำเข้าข้อมูลจากโฮลเซลล์</h3>';
$arr['title'] .= '<div class="alert alert-warning fs-15">
    <p>หมายเหตุสำคัญ:</p>
    <ul class="uiListStandard">'.
        '<li>หากคุณยืนยันการนำเข้าข้อมูลจากโฮลเซลล์แล้ว คุณสามารถปรับแต่งและแก้ไขข้อมูลได้บางส่วนเท่านั้น</li>'.
        '<li>หากมีการปิดการใช้งานจากโฮลเซลล์นี้ โปรแกรมทัวร์นี้ถูกปิดไปด้วย</li>'.
        '<li>คุณไม่สามารถลบโปรแกรมนี้ออกจากสินค้าของคุณอย่างถาวรได้</li>'.
    '</ul>
</div>';

// $arr['title'] .= '<div class="fsm text-muted" style="font-size:13px">แก้ไขล่าสุด: '.$Fn->q('time')->live( $data->updated_at ).'</div>';



foreach ($tabs as $key => $value) {

    include "forms/{$value['id']}.php";

}


# body
$arr['body'] = '<div data-plugins="formstaps|formseo" class="form-staps row no-gutters">'.

    '<div class="col-md-4 order-md-2 mb-md-0 mb-sm-4 form-staps-tools">'.
        // '<div class="form-staps-tools__header"></div>'.

        '<ul class="form-staps-tools__nav">'. $tab .'</ul>'.
    '</div>'.

    '<div class="col-md-8 order-md-1"><div class="form-staps-content">'.
        '<div data-stap-section="basic" class="form-staps-section active">'.$formBasic.'</div>'.
        '<div data-stap-section="plans" class="form-staps-section">'.$seriesPlansForm.'</div>'.
        '<div data-stap-section="hotels" class="form-staps-section">'.$seriesHotelsForm.'</div>'.
        '<div data-stap-section="meals" class="form-staps-section">'.$seriesMealsForm.'</div>'.

        '<div data-stap-section="period" class="form-staps-section">'.$periodsForm.'</div>'.

        '<div data-stap-section="gallery" class="form-staps-section">'.$gallery.'</div>'.

        '<div data-stap-section="doc" class="form-staps-section">'.$doc.'</div>'.

        '<div data-stap-section="conditions" class="form-staps-section">'.$conditions.'</div>'.

        '<div data-stap-section="seo" class="form-staps-section">'.$formSEO.'</div>'.
    '</div></div>'.


'</div>';



$arr['summary'] = '<div class="media">'.
    '<div class="pic-wrap mr-2" style="width: 86px;"><div class="pic squared" data-type="image"></div></div>'.
    '<div class="media-body">'.
        '<div class="fwb">'. $data->serie->code .'</div>'.
        '<div class="fwb">'. $data->serie->name .'</div>'.
        '<div class="text-me">โฮลเซลล์ : '. $data->serie->wholesale->name .'</div>'.
    '</div>'.
'</div>';

$arr['form'] = '<form class="model-body-p0" method="post" action="'.asset( "/carts/{$data->id}" ).'" data-plugins="formSubmit"></form>';


$statusActive = 2;
$status = '';

if( empty($is_default) ){

    foreach ($statusList as $key => $value) {

        if( $value['id']==0 ) continue;
        $active = $statusActive==$value['id']? ' selected': '';
        $status .= '<option'.$active.' value="'.$value['id'].'">'.$value['name'].'</option>';
    }

    $status = '<select class="form-control input-group-text" name="status">'.$status.'</select>';
}

# fotter: buttons
$arr['button'] = '<div class="d-flex justify-content-end">'.
    $status.
    '<button type="submit" class="btn btn-primary btn-submit ml-2"><span class="btn-text">นำเข้าข้อมูล</span></button>'.
'</div>';

$arr['width'] = 1200;

http_response_code(200);
echo json_encode($arr);
