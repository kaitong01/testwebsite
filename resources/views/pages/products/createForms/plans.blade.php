<?php


$form = new Form();
$formHtml = $form->create()
    // set From
    ->elem('div')
    ->addClass('form-insert form-series')


->field("wholesale_id")->label( 'โฮลเซลล์' )->autocomplete('off')->addClass('form-control')
->field("country_id")->label( 'ประเทศ' )->autocomplete('off')->addClass('form-control')
->field("airline_id")->label( 'สายการบิน' )->autocomplete('off')->addClass('form-control')

->hr( '<div class="form-hr white"><span>ทัวร์</span></div>' )

->field("code")->label( 'โค้ด' )->autocomplete('off')->addClass('form-control')
 ->field("name")->label( 'ชื่อ' )->autocomplete('off')->addClass('form-control')


->field("days")->label( 'จำนวนวัน*' )->autocomplete('off')->addClass('form-control')
->field("nights")->label( 'จำนวนคืน*' )->autocomplete('off')->addClass('form-control')
->field("price_at")->label( 'ราคาเริ่มต้น*' )->autocomplete('off')->addClass('form-control')


 ->field("description")->type( 'textarea' )->label( 'ไฮไลท์' )->autocomplete('off')->addClass('form-control')->attr('data-plugin', 'autosize')
->html();

// dd($data->plans);

?>

<div class="business-settings-section" data-plugin="seriesPlansForm" data-options="<?=htmlentities(json_encode(array(
    'data'=> !empty($data->plans)? json_decode($data->plans, 1): array()
)))?>">


	<div class="business-settings-section-header">
        <h2>โปรแกรมเดินทาง</h2>
        <p class="desc">กรอกรายละเอียดแผนการเดินทาง ละเอียดที่พัก โรงแรม และมืออาหาร</p>

	</div>

	<div class="business-settings-section-body">
        <ul class="travel-plan" role="listsbox"></ul>
    </div>



</div>


<div class="business-settings-section" data-plugin="seriesMealsForm" data-options="<?=htmlentities(json_encode(array(
    'data'=> !empty($data->meals)? json_decode($data->meals, 1): array()
)))?>">

    <div class="business-settings-section-header">
        <h2>มื้ออาหาร</h2>
    </div>


    <div class="business-settings-section-body">

        <div id="meals_fieldset" class="control-group">
            <div class="controls">

                <table class="table-period-form" style="    width: auto;">
                    <thead>
                        <tr>
                            <th class="td-index">วันที่</th>
                            <th class="td-checkbox">เช้า</th>
                            <th class="td-checkbox">เที่ยง</th>
                            <th class="td-checkbox">เย็น</th>
                            <th class="td-action"></th>
                            {{-- <th style="width: 60%"></th> --}}
                        </tr>
                    </thead>

                    <tbody role="listsbox"></tbody>
                </table>

                <div class="notification"></div>
            </div>
        </div>

        <div id="meals_note_fieldset" class="control-group">
            <label for="meals_note" class="control-label">หมายเหตุ</label>
            <div class="controls">
            <textarea id="meals_note" autocomplete="off" class="form-control" name="meals_note" rows="2" data-plugin="autosize">{{ !empty($data->meals_note)? $data->meals_note: '' }}</textarea>
                <div class="notification"></div>
            </div>
        </div>
    </div>
</div>


<div class="business-settings-section" data-plugin="seriesHotelsForm" data-options="<?=htmlentities(json_encode(array(
    'data'=> !empty($data->hotels)? json_decode($data->hotels, 1): array()
)))?>">

    <div class="business-settings-section-header">
        <h2>โรงแรมและที่พัก</h2>
    </div>


    <div class="business-settings-section-body">


        <div id="hotels_fieldset" class="control-group">
            <div class="controls">
                <table class="table-period-form">
                    <thead>
                        <tr>
                            <th class="td-index">คืนที่</th>
                            <th>โรงแรมและที่พัก</th>
                            <th>ระดับ</th>
                            <th class="td-action"></th>
                        </tr>
                    </thead>

                    <tbody role="listsbox"></tbody>
                </table>

                <div class="notification"></div>
            </div>
        </div>

        <div id="hotels_note_fieldset" class="control-group">
            <label for="hotels_note" class="control-label">หมายเหตุ</label>
            <div class="controls">
                <textarea id="hotels_note" autocomplete="off" class="form-control" name="hotels_note" rows="2" data-plugin="autosize">{{ !empty($data->hotels_note)? $data->hotels_note: '' }}</textarea>
                <div class="notification"></div>
            </div>
        </div>

    </div>

</div>
