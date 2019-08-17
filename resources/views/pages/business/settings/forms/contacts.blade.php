<?php
$contacts = array();

$contacts[] = array('id'=>'email', 'label'=>'อีเมล (เพิ่มได้มากสุด 2 รายการ)', 'max'=>2);
$contacts[] = array('id'=>'phone', 'label'=>'หมายเลขโทรศัพท์ (เพิ่มได้มากสุด 3 รายการ)', 'max'=>3);
$contacts[] = array('id'=>'fax', 'label'=>'แฟกซ์', 'max'=>1);
$contacts[] = array('id'=>'line', 'label'=>'LINE (เพิ่มได้มากสุด 3 รายการ)', 'max'=>3);
$contacts[] = array('id'=>'facebook', 'label'=>'FACEBOOK', 'max'=>1);
$contacts[] = array('id'=>'instagam', 'label'=>'INSTAGRAM', 'max'=>1);
$contacts[] = array('id'=>'youtube', 'label'=>'YOUTUBE', 'max'=>1);

$dataContacts = array();
if( !empty( $item->contacts_json ) ){

$dataContacts = json_decode($item->contacts_json, 1);

// dd( $dataContacts );
}

function tableContactItem($seq, $data=''){

// $action =

return '<tr>
<td class="td-input">
    <div class="controls">
        <input autocomplete="off" class="form-control" type="text" name="contacts['.$seq.'][]" value="'.$data.'">


        <div class="td-action">
            <button tabindex="-1" type="button" class="btn btn-mini btn-light" data-action="down"><i class="fa fa-arrow-down"></i></button>
            <button tabindex="-1" type="button" class="btn btn-mini btn-light" data-action="up"><i class="fa fa-arrow-up"></i></button>
            <button tabindex="-1" type="button" class="btn btn-mini btn-light" data-action="add"><i class="fa fa-plus"></i></button>

            <button tabindex="-1" type="button" class="btn btn-mini btn-light" data-action="del"><i class="fa fa-remove"></i></button>
        </div>
    </div>
</td>
</tr>';
}

?>

<form action="/business/update/contacts" method="post" data-plugin="formSubmit" class="business-settings-section">
    {{ csrf_field() }}
    <input type="hidden" name="_method" value="PUT" autocomplete="off" >
    <div class="business-settings-section-header">
        <h2>ข้อมูลการติดต่อ</h2>
        {{-- <p>เพิ่มข้อมูลการติดต่อของคุณ เพื่อให้ลูกค้าสามารถติดต่อกับคุณได้</p> --}}
    </div>
    <div class="business-settings-section-body">

        <div class="form-insert form-vertical">

            <div class="row">
                <div class="col-sm-6 mbl">

                    <fieldset id="contacts_fieldset" class="control-group">

                        <table class="table-contact" data-plugin="TableContact"><?php

                            foreach ($contacts as $key => $value) {


                                if( !empty($dataContacts[$value['id']]) ){

                                    $items ='';
                                    foreach ($dataContacts[$value['id']] as $i => $val) {
                                        $items .= tableContactItem( $value['id'], $val );
                                    }
                                }
                                else{
                                    $items = tableContactItem( $value['id'] );
                                }


                            ?>

                            <tbody>
                                <tr>
                                    <td class="td-label"><label class="control-label"><?=$value['label']?></label></td>
                                </tr>
                            </tbody>
                            <tbody data-max="<?=$value['max']?>">
                                <?=$items?>
                            </tbody>
                            <?php } ?>

                        </table>

                        <div class="notification"></div>

                    </fieldset>
                </div>
            </div>
        </div>
    </div>

    <div class="business-settings-section-footer d-flex justify-content-between">
        <div></div>
        <div>
            <button type="submit" class="btn btn-primary btn-submit">บันทึก</button>
        </div>
    </div>
</form>
