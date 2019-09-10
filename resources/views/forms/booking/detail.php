<?php

$Fn = new Fn;

$tr = "";
$i = 0;
foreach ($item as $row ) {
  $i++;
    $tr .='
    <tr>
      <th scope="row">'.$i.'</th>
      <td>'.$row->detail_name.'</td>
      <td>'.number_format($row->detail_price,2).'</td>
      <td>'.$row->detail_count.'</td>
      <td>'.number_format($row->detail_price*$row->detail_count,2).'</td>
    </tr>
    ';
}

$form = new Form();
$formBasic = $form->create()
    // set From
    ->elem('div')
    ->addClass('form-insert')

    ->field("permalink")
        ->label('BOOKING-NO : '.$item[0]->booking_no)

        ->text('<div class="row">
                <div class="col-12">
                  <table class="table">
                  <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Total</th>
                      </tr>
                    </thead>
                    <tbody>
                      '.$tr.'
                      <tr>
                      <td align="center" colspan="4">
                      <h4>Subtotal</h4>
                      </td>
                      <td><h4>'.number_format($item[0]->booking_amount,2).'</h4></td>
                      <tr>
                    </tbody>
                  </table>
                </div>
            </div>')
->html();



# body
$arr['body'] = '<div data-plugins="formstaps|formseo" class="form-staps row no-gutters">'.
    '<div class="col-12 col-sm-12"><div class="form-staps-content">'.
        '<div data-stap-section="basic" class="form-staps-section active">'.$formBasic.'</div>'.
    '</div></div>';

// $arr['form'] = '<form class="model-body-p0" method="post" action="'.asset( $formAction ).'" data-plugin="formSubmit"></form>';


$statusCurr = !empty($item['status'])? $item['status']: 1;

$status = '';
$statusList = array();
$statusList[] = array('id'=>1, 'name'=>'ใช้งาน');
$statusList[] = array('id'=>2, 'name'=>'ระงับ');



# fotter: buttons

// $arr['cancel'] = '<button type="button" class="btn btn-sm btn-danger" data-action="close"><span class="btn-text">ยกเลิก</span></button>';
// $arr['close'] = true;
$arr['width'] = '80%';
// $arr['bg'] = 'blue';
// $arr['effect'] = 7;

// return response()->json($arr, 404);

http_response_code(200);
echo json_encode($arr);
