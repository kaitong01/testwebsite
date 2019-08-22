<?php


$form = new Form();
$formHtml = $form->create()
    // set From
    ->elem('div')
    ->addClass('form-insert form-series')


->field("route_id")->label( 'เส้นทาง' )->autocomplete('off')->addClass('form-control')->select( [] )->value( !empty( $data['route_id'] )? $data['route_id']: '' )
->field("airline_id")->label( 'สายการบิน' )->autocomplete('off')->addClass('form-control')->select( [] )->value( !empty( $data['airline_id'] )? $data['airline_id']: '' )

->hr( '<div class="form-hr white"><span>ทัวร์</span></div>' )

->field("code")->label( 'โค้ด' )->autocomplete('off')->addClass('form-control')->value( !empty( $data['code'] )? $data['code']: '' )
 ->field("name")->label( 'ชื่อ' )->autocomplete('off')->addClass('form-control')->value( !empty( $data['name'] )? $data['name']: '' )


->field("days")->label( 'จำนวนวัน*' )->autocomplete('off')->addClass('form-control')->value( !empty( $data['days'] )? $data['days']: '' )
->field("nights")->label( 'จำนวนคืน*' )->autocomplete('off')->addClass('form-control')->value( !empty( $data['nights'] )? $data['nights']: '' )
->field("price_at")->label( 'ราคาเริ่มต้น*' )->autocomplete('off')->addClass('form-control')->value( !empty( $data['price_at'] )? $data['price_at']: '' )


 ->field("description")->type( 'textarea' )->label( 'ไฮไลท์' )->autocomplete('off')->addClass('form-control')->attr('data-plugin', 'autosize')->value( !empty( $data['description'] )? $data['description']: '' )
->html();


?>

<div class="business-settings-section">

	<div class="business-settings-section-header">
        <h2>ข้อมูลเบื้องต้น</h2>
        <p class="desc">รายละเอียดเนื้อหาเกี่ยวกับแพ็คเกจทัวร์</p>

	</div>

	<div class="business-settings-section-body">
        <?=$formHtml?>
    </div>

</div>
