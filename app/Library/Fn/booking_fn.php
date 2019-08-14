<?php

class Booking_Fn extends Fn
{
	public function formHeader($data)
	{
		$cols = array();

		$reservation = array();
		$name = $data['cus_name'];
		if( !empty($data['cus_tel']) ){
			$name .= "(<a>{$data['cus_tel']}</a>)";
	 	}
		$reservation[] = array('id'=>'', 'name'=>'ชื่อลูกค้า', 'value'=> $name);
		// $reservation[] = array('id'=>'', 'name'=>'อีเมล์', 'value'=>$data['cus_tel']);
		// $reservation[] = array('id'=>'', 'name'=>'เบอร์โทร', 'value'=>$data['cus_tel']);

		$data['company_name'] = trim($data['company_name']);
		$agen_name = "{$data['agen_name']}({$data['company_name']})";
		$reservation[] = array('id'=>'', 'name'=>'Agency', 'value'=>$agen_name);

		$time = strtotime($data['create_date']); 
		$date = '<span>'.date('d ', $time). $this->q('time')->month( date('n', $time) ).date(' Y H:i', $time).'</span>';

		if( !empty($data['create_user_id']) ){

			$createby_name = $data['createby_nickname'];
			if( empty($createby_name) ){
				$createby_name = trim("{$data['createby_fname']} {$data['createby_lname']}") ;
			}
			$date .= ' · <span class="fcg">ในระบบ('.$createby_name.')</span>';
		}
		else{
			$date .= ' · <span class="fcg">หน้าเว็บ</span>';
		}
		

		$reservation[] = array('id'=>'', 'name'=>'วันที่จอง', 'value'=> $date );
		
		$cols[] = array('id'=>'','name'=>'ข้อมูลผู้จอง', 'icon'=>'address-book-o', 'items'=>$reservation);


		$peroid = array();
		$peroid[] = array('id'=>'', 'name'=>'แพ็กเกจ', 'value'=> $data['tour_code'].' · '.$data['tour_name']  );
		$peroid[] = array('id'=>'', 'name'=>'วันที่เดินทาง', 'value'=> $this->q('time')->eventDate( $data['start_date'], $data['end_date'] ) );
		$peroid[] = array('id'=>'', 'name'=>'บัส', 'value'=> $data['bus_no']);
		$peroid[] = array('id'=>'', 'name'=>'ที่นั้ง', 'value'=> "<span data-ref=\"seat\" data-val=\"{$data['seat']}\">{$data['seat']}</span> /  รับได้ <span data-ref=\"seat_balance\" data-val=\"{$data['seat_balance']}\">{$data['seat_balance']}</span>");
		$cols[] = array('id'=>'','name'=>'ข้อมูลการเดินทาง', 'icon'=>'plane', 'items'=>$peroid);


		$invoice = array();
		$invoice[] = array('id'=>'', 'name'=>'INVOICE NO.', 'value'=>$data['invoice_code']);
		$cols[] = array('id'=>'','name'=>'INVOICE', 'icon'=>'money', 'items'=>$invoice);


		$col = '';
		foreach ($cols as $vals) {
			
			$tr = '';
			foreach ($vals['items'] as $key => $value) {

				$val = isset($value['value']) ? $value['value']:'';
				$tr .= '<tr>';

					$tr .= '<td class="label">'.$value['name'].'</td>';
					$tr .= '<td class="data">'.$val.'</td>';
				$tr .= '</tr>';
			}

			$icon = isset($vals['icon']) ? '<i class="icon-'.$vals['icon'].' mrs"></i>': '';

			$col .= '<td class="td-col">'.

				'<h3>'.$icon.'<span>'.$vals['name'].'</span></h3>'.
				'<table class="table-info">'.$tr.'</table>'.
			'</td>';
		}

		return '<div class="table-headerBooking-warp">
			<table class="table-headerBooking"><tr>'.$col.'</tr></table>
		</div>';

		
	}

	public function formHeaderFirst($data)
	{
		

		$metaList = array();
		$metaList[] = array('id'=>'name', 'name'=>'แพ็กเกจ', 'value'=> $data['ser_code'].' · '.$data['ser_name'] );
		$metaList[] = array('id'=>'date', 'name'=>'วันที่เดินทาง', 'value'=> $data['date_str'] );
		$metaList[] = array('id'=>'no', 'name'=>'Bus', 'value'=> $data['bus']['no']);
		$metaList[] = array('id'=>'seat', 'name'=>'ที่นั้ง', 'value'=> $data['bus']['seat']);
		$metaList[] = array('id'=>'seat_balance', 'name'=>'รับได้', 'value'=> $data['bus']['seat_balance']);

		$metaList_str = '';
		foreach ($metaList as $key => $value) {
			
			$metaList_str .= '<li class="'.$value['id'].'"><strong>'.$value['name'].'</strong><span data-ref="'.$value['id'].'">'.$value['value'].'</span></li>';
		}

		return '<div class="table-headerBooking-warp">
			<h3><i class="icon-plane mrs"></i><span>ข้อมูลการเดินทาง</span></h3>
			<ul class="table-headerBooking-metaList">'.$metaList_str.'</ul>
		</div>';
	}

	public function form($options=array()){

		$dataBooking = isset($options['booking']) ? $options['booking']: array();
		$opt = isset($options['data']['bus']['options']) ? $options['data']['bus']['options']: array();
		// print_r($opt); die;

		$wanted = $options['data']['bus']['seat_balance'];

		if( !empty($dataBooking['pax']) ){
			$wanted += $dataBooking['pax'];
		}

		$optForm = array(
			'deposit' => !empty($options['datePayment']['deposit']['value']) ? $options['datePayment']['deposit']['value']: 0,
			'extraList' => !empty($options['extraList'])? $options['extraList']: array(),
			'extraListData' => !empty($options['extraListData'])? $options['extraListData']: array(),

		    'seat'=> $options['data']['bus']['seat'],
			'seat_balance' => $wanted,

			'booking' => $dataBooking,
		);


		if( !empty($dataBooking) ){
			$dataBooking['seat'] = $options['data']['bus']['seat'];
			$dataBooking['seat_balance'] = $options['data']['bus']['seat_balance'];

			if( !empty($dataBooking['detail_arr'][6]) ){
				$optForm['extraListData'] = $dataBooking['detail_arr'][6];
			}
		}


		// จำนวนผู้เดินททาง
		$travelerTable = array(); $seq = 0;
		foreach ($opt['price_values'] as $key => $value) {
			$seq++;

			$val = 0;
			if( !empty($dataBooking['detail_arr'][0])  ){
				foreach ($dataBooking['detail_arr'][0] as $i => $_val) {
					if( $seq==$_val['seq'] ){
						$val = $_val['value'];
					}
				}
			}

			$travelerTable[] = array('key'=>'pax_'.$key, 'label'=>$value['name'], 'cls'=>'input-value-pax input-value-people input-value-com', 'name'=>'traveler['. (!empty($value['key']) ? $value['key']: '') .']', 'value'=> $val);
		}


		$travelerTable[] = array('key'=>'infant', 'label'=>'Infant', 'cls'=>'input-value-people', 'name'=>'traveler[infant]', 'value'=>!empty($dataBooking['detail_arr'][1][0]['value']) ? $dataBooking['detail_arr'][1][0]['value']: 0);


		if( !empty($opt['joinland']) ){
			$travelerTable[] = array('key'=>'joinland', 'label'=>'Joinland', 'cls'=>'input-value-com', 'name'=>'traveler[joinland]', 'value'=>!empty($dataBooking['detail_arr'][2][0]['value']) ? $dataBooking['detail_arr'][2][0]['value']: 0);
		}
	

		// roomOfTypeTable
		$roomOfTypeTable = array();
		foreach ($opt['room_of_types'] as $key => $value) {

			if( $value['id']=='single' ) continue;
			$_key = "room_{$value['id']}";
			$val = !empty($dataBooking['rooms'][$_key])
				? $dataBooking['rooms'][$_key]
				: 0;

			$roomOfTypeTable[] = array('key'=>$_key, 'label'=>$value['name'], 'type'=>'room', 'name'=>'room['.$value['id'].']', 'quota'=>$value['quota'], 'value'=>$val);

		}

		$roomSingleVal = !empty($dataBooking['rooms']['room_single'])
			? $dataBooking['rooms']['room_single']
			: 0;

		$roomOfTypeTable[] = array('key'=>'room_single', 'label'=>'Single', 'type'=>'room', 'name'=>'room[single]', 'value'=>$roomSingleVal, 'quota'=>1);


		// สรุป ด้านขวา
		$priceTable = array();
		foreach ($opt['price_values'] as $key => $value) {
			$priceTable[] = array('key'=>'pax_'.$key, 'name'=>$value['name'], 'value'=> $value['value'], 'is_'=>true);
		}

		$priceTable[] = array('key'=>'infant', 'name'=>'Infant', 'value'=> $opt['infant'] );
		if( !empty($opt['joinland']) ){
			$priceTable[] = array('key'=>'joinland', 'name'=>'Joinland', 'value'=> $opt['joinland'] );
		}
		$priceTable[] = array('key'=>'room_single', 'name'=>'Sing Charge', 'value'=> $opt['single_charge'] );


		$priceAdditional = array();
		if( !empty($opt['price_additional']) ){
			foreach ($opt['price_additional'] as $key => $value) {
				$priceAdditional[] = array('cls'=>'input-value-pax', 'name'=>$value['name'], 'value'=>$value['value']);
			}
		}


		$commissionList = array();
		// Commission
		foreach ($opt['commission'] as $key => $value) {
			$commissionList[] = array('name'=>$value['name'], 'price'=>$value['value'], 'value'=>'auto', 'total'=>0);
		}


		// Discounts
		$discountList = array();
		foreach ($opt['discounts'] as $key => $value) {
			$discountList[] = array('name'=>$value['name'], 'price'=>$value['value'], 'value'=>'auto', 'total'=>0);
		}


		if( !empty($opt['discount_extra_input']) ){
			$discountList[] = array('name'=>'ลดพิเศษ', 'value'=>!empty($dataBooking['detail_arr'][9][0]['price'])? round($dataBooking['detail_arr'][9][0]['price']): 0, 'is_input'=>1);
		}

		$form = new Form();
		$contactForm = $form->create()->elem('div')->addClass('form-insert')

		    ->field( 'sales' )->label( 'Sales Contact*' )->select( $options['salesList'] )->autocomplete('off')->value( !empty($dataBooking['user_id']) ? $dataBooking['user_id']:'' )
		    ->field( 'company' )->label( 'Agent*' )->select( $options['agencyList'] )->autocomplete('off')->value( !empty($dataBooking['company_id']) ? $dataBooking['company_id']:'' )
		    ->field( 'agent' )->label( 'Sales Agent*' )->addClass('inputtext')->select()->autocomplete('off')
		    ->field( 'book_cus_name' )->label( 'ชื่อลูกค้า*' )->addClass('inputtext')->autocomplete('off')->value( !empty($dataBooking['cus_name']) ? $dataBooking['cus_name']:'' )
		    ->field( 'book_cus_tel' )->label( 'เบอร์โทรลูกค้า*' )->addClass('inputtext')->autocomplete('off')->value( !empty($dataBooking['cus_tel']) ? $dataBooking['cus_tel']:'' )
		    ->field( 'book_comment' )->label( 'คำสั่งพิเศษ' )->addClass('inputtext')->type( 'textarea' )->attr('data-plugin', "autosize")->autocomplete('off')->value( !empty($dataBooking['comment']) ? $dataBooking['comment']:'' )
		->html();


		$travelerTR = '';
		foreach ($priceTable as $key => $value) {

			$val = isset($value['value']) ? intval($value['value']): 0;

		    $travelerTR .= '<tr data-summary="'.$value['key'].'">'.
		       	'<td class="label">'.$value['name'].'</td>'.
		        '<td class="data"><span class="value" data-value="'.$val.'">'. number_format( $val ) .'</span> <span class="x">x</span> <span class="count">0</span> <span>=</span> <span class="sum">0</span></td>'.
		    '</tr>';
		}


		$priceAdditionalTR = '';
		foreach ($priceAdditional as $key => $value) {
		    $priceAdditionalTR .= '<tr data-summary-additional="'.$key.'">
		        <td class="label">'.$value['name'].'</td>
		        <td class="data"><span class="value" data-value="'.$value['value'].'">'. number_format($value['value']) .'</span> <span class="x">x</span> <span class="count">0</span> <span>=</span> <span class="sum">0</span></td>
		    </tr>';
		}


		$depCountdownStr = '';
		if( !empty($options['datePayment']['deposit']['date']) ){
		    $depCountdownStr = '<tr><td colspan="2" style="font-size: 14px;padding-right: 8px;">';

		    $depCountdownStr .= date('j/m/Y H:i', strtotime($options['datePayment']['deposit']['date']));
		    $depCountdownStr .= '</td></tr>';
		}

		$fulCountdownStr = '';
		if( !empty($options['datePayment']['fullpayment']['date']) ){
		    $fulCountdownStr = '<tr><td colspan="2" style="font-size: 14px;padding-right: 8px;">';
		    $fulCountdownStr .= date('j/m/Y H:i', strtotime($options['datePayment']['fullpayment']['date']));

		    /*if( !empty($options['datePayment']['fullpayment']['countdown_str']) ){
		        $fulCountdownStr .= " ({$options['datePayment']['fullpayment']['countdown_str']})";
		    }*/

		    $fulCountdownStr .= '</td></tr>';
		}


		$html = '<div class="booking-form-wrap" data-plugin="bookingform" data-options="'.Fn::stringify($optForm).'">'.
		    
		    ( !empty($dataBooking) ? $this->formHeader($dataBooking): $this->formHeaderFirst($options['data']) ).
		    // ( !empty($dataBooking) ? $this->formHeaderFirst($options['data']): $this->formHeaderFirst($options) ).

		    // ( $wanted<=0
		    //     ? '<div class="pam uiBoxRed mam fwb">*เนื่องจากมีจำนวนการจองที่นั่งเต็มจำนวนแล้ว คุณจะสามาจองทัวร์นี้ได้ในสถานะ Waiting List เท่านั้น</div>'
		    //     : '' 
		    // ).

		    '<div class="booking-form-table-wrap" style="border-width: 1px 0 0"><table class="booking-form-table"><tbody>'.

		        '<tr>'.
		            '<td class="td-contact">'. 
		                '<header>Contact</header>'.
		                $contactForm.
		            '</td>'.


		            '<td>
		            	
		                <table>
		                    <tr>
		                        <td class="" style="padding: 10px;vertical-align: top;width: 50%">

		                        	<fieldset id="traveler_fieldset" class="control-group">
		                            <header>Traveler Info</header>'.

		                            $this->inputValueNumber($travelerTable).

		                            '<div class="notification"></div>'.
	                				'</fieldset>'.
		                        '</td>
		                        <td class="" style="padding: 10px;vertical-align: top;">
		                            <header>Room Type</header>'.
		                            $this->inputValueNumber($roomOfTypeTable).
		                        '</td>
		                    </tr>
		                </table>
		                	
		            </td>'.


		            '<td rowspan="2" class="" style="padding: 10px;padding-bottom: 190px;width: 300px;vertical-align: top;border-left: 1px dashed #ccc;position: relative;background-color: #fff;">'.

		                '<table class="booking-table-calculatePrice" role="summary">'.

		                    '<tbody><tr><td class="head frist" colspan="2">ราคา</td></tr></tbody>'.

		                    '<tbody data-summary-section="traveler">'.
		                        $travelerTR.
		                        '<tr><td colspan="2" class="subtotal">0</td></tr>'.
		                    '</tbody>'.


		                    ( !empty($priceAdditionalTR)

		                    	? '<tbody data-summary-section="additional">

		                    			<tr><td class="head frist" colspan="2"><i class="icon-info-circle mrs fc-red"></i><span>บวกราคาเพิ่ม</span></td></tr>'.
				                    
				                    	$priceAdditionalTR.
				                   	// '<tr><td colspan="2" class="subtotal">0</td></tr>'.
				                   '</tbody>'
		                    	: ''
		                    ).


		                    '<tbody class="extralist-head"><tr>
		                        <td colspan="2" class="head">
		                            <div class="clearfix">
		                                <span class="lfloat title">รายการเพิ่มเติม</span>
		                                <span class="rfloat js-extralist-total" data-value="0" style="color: #465cd8;">0</span>
		                            </div>
		                        </td>
		                    </tr></tbody>'.

		                    '<tbody class="extralist-list" data-summary-section="extralist" style="display:none;"></tbody>'.

		                    '<tbody>'.
		                        '<tr><td colspan="2" style="padding-top:20px;border-width: 0"></td></tr>'.
		                        '<tr><td class="head" colspan="2">คอมมิชชั่น</td></tr>'.
		                    '</tbody>'.

		                    $this->discountTable( $commissionList ).


		                    ( !empty($discountList)

		                    	? '<tbody>'.
				                        '<tr><td colspan="2" style="padding-top:0px;border-width: 0"></td></tr>'.
				                        '<tr><td class="head" colspan="2">ส่วนลด</td></tr>'.
				                    '</tbody>'.

				                    $this->discountTable( $discountList )

		                    	: ''
		                    ).
		                    
		                '</table>'.

		                '<div style="position: absolute;bottom: 2px;right: 2px;text-align: right;left: 2px">

		                    <div style="padding: 8px;">
		                        <table data-summary-section="total">
		                            <tr>
		                                <td style="padding-right: 10px;">
		                                    <div style="font-size: 11px;line-height: 1">Pax</div>
		                                    <div style="font-size: 20px;font-weight: bold;color: #4CAF50" class="pax">0</div>
		                                </td>
		                                <td style="width: 100%"></td>
		                                <td style="padding-right: 10px;">
		                                    <div style="font-size: 11px;line-height: 1">Discount</div>
		                                    <div style="font-size: 20px;font-weight: bold;color: red" class="discount">0</div>
		                                </td>
		                                <td style="padding-left: 10px;border-left: 1px solid #ccc">
		                                    <div style="font-size: 11px;line-height: 1">Total</div>
		                                    <div style="font-size: 20px;font-weight: bold;color: #3f51b5" class="total">0</div>
		                                </td>
		                            </tr>
		                        </table>
		                    </div>
		                    
		                    <div style="background-color: #f0f0f0">
		                        <table data-summary-section="pay">
		                            <tr>
		                                <td style="font-weight: bold;padding-top: 14px">Deposit:</td>
		                                <td style="text-align: right;padding-bottom: 10px;padding: 8px 8px 0">
		                                    <div style="font-size: 24px;font-weight: bold;" class="deposit">0</div>
		                                </td>
		                            </tr>'.

		                            $depCountdownStr.

		                            '<tr><td colspan="2" style="padding: 4px;"></td></tr>'.

		                            '<tr>
		                                <td style="font-weight: bold;padding-top: 14px;white-space: nowrap;width: 30px;padding-left: 8px;border-top: 1px solid #fff;">Full Payment:</td>
		                                <td style="text-align: right;padding: 8px 8px 0;border-top: 1px solid #fff;">
		                                    <div style="font-size: 24px;font-weight: bold;" class="fullpayment">0</div>
		                                </td>
		                            </tr>'.

		                            $fulCountdownStr.

		                            '<tr><td colspan="2" style="padding: 4px;"></td></tr>
		                        </table>

		                    </div>
		                </div>'.
		            '</td>'.
		        '</tr>'.


		        '<tr>'.
		            '<td colspan="2" style="padding: 10px;border-top: 1px solid #ddd;background: #fff;">'.
		                '<div class="table-booking-extra-wrap" role="extralist">'.
		                    '<table class="table-booking-extra">
		                        <thead>
		                            <tr>
		                                <th class="td-no">#</th>
		                                <th class="td-name">รายการเพิ่มเติม</th>
		                                <th class="td-price">ราคา</th>
		                                <th class="td-qty">จำนวน</th>
		                                <th class="td-sum">รวม</th>
		                                <th class="td-actions"></th>
		                            </tr>
		                        </thead>
		                        <tbody role="listsbox"></tbody>
		                        <tfoot>
		                                <tr>
		                                    <td colspan="4" style="text-align: right"></td>
		                                    <td class="td-sum"><span style="font-weight: bold;font-size: 18px;" data-ref="total">-</span></td>
		                                    <td></td>
		                                </tr>
		                            </tfoot>
		                        </table>'.
		                '</div>'.


		                '<header>หมายเหตุ</header><div><textarea class="inputtext" name="remark" data-plugin="autosize" style="width: 100%" autocomplete="off">'.(!empty($dataBooking['remark'])? $dataBooking['remark']: '').'</textarea></div>'.
		            '</td>'.
		        '</tr>'.
		    '</tbody></table></div>'.
		'</div>';


		return $html;
	}

	public function inputValueNumber($fields)
	{
	    $field = '';
	    foreach ($fields as $key => $value) {

	        $cls = 'inputtext input-value-number';
	        if( isset($value['cls']) ){
	            $cls .= " {$value['cls']}";
	        }

	        // set attr 
	        $quota = isset($value['quota'])? ' data-quota="'.$value['quota'].'"': '';

	        
	        $name = isset($value['name'])? $value['name']: $value['key'];
	        $type = isset($value['type'])? ' data-type="'.$value['type'].'"': '';

	        $field .=''.
	            '<fieldset id="'.$value['key'].'_fieldset" class="control-group-number control-group">'.
	                '<label for="'.$value['key'].'" class="control-label">'.$value['label'].'</label>'.
	                '<div class="controls touchtime-wrap">'.
	                    '<span class="gbtn"><button type="button" class="btn" data-value-action="minus"><i class="icon-minus"></i></button></span>'.
	                    '<input id="'.$value['key'].'" class="'.$cls.'" autocomplete="off" type="text" name="'.$name.'" data-name="'.$value['key'].'"'.(!empty($value['value'])?' value="'.$value['value'].'"':'').$type.$quota.'>'.
	                    '<span class="gbtn r"><button type="button" class="btn" data-value-action="plus"><i class="icon-plus"></i></button></span>'.
	                    // '<div class="notification"></div>'.
	                    '<div class="leyerNumber list-touchtime"></div>'.
	                '</div>'.
	            '</fieldset>';
	        
	    }
	    return '<div class="form-insert form-vertical">'.$field.'</div>';
	}


	public function discountTable($lists)
	{
		
		$tr = '';
		foreach ($lists as $key => $val) {

			$input = '';
			if( isset($val['is_input']) ){
				$input = '<input id="discount_extra" type="text" name="discount_extra" class="inputtext input-extra-discount" style="width: 100%" autocomplete="off" value="'.$val['value'].'" />';
			}
			else{
				$input = 

				'<input type="hidden" data-discount-name="name" name="discount[name][]" class="inputtext" autocomplete="off" value="'.$val['name'].'">'.
            	'<input type="hidden" data-discount-name="price" name="discount[price][]" class="inputtext" autocomplete="off" value="'.$val['price'].'">'.
            	'<input type="hidden" data-discount-name="value" name="discount[value][]" class="inputtext" autocomplete="off" value="0">'.

				'<span class="value" data-value="'.round($val['price']).'">'.
					number_format($val['price']).'</span> <span class="x">x</span> <span class="count">0</span> <span>=</span> <span class="sum">0</span>';
			}
			
			$is_auto = $val['value']=='auto';

			$tr .= '<tr>
                <td class="label">'.$val['name'].'</td>
                <td class="data">'.

                	$input.
                '</td>
            </tr>';
		}

		// $tr .= '<tr><td colspan="2" class="subtotal">0</td></tr>';

		return '<tbody class="t-discount" data-summary-section="discount">'.$tr.'</tbody>';
	}


	public function alertForm($data)
	{
		
	}

	public function confirmForm( $data=array() )
	{
		$bookingList = array();


		foreach ($data['bookingList'] as $key => $value) {
			
			if( !isset($bookingList[$value['type']]) ){

				/*if( in_array($value['type'], array(1,2)) ){
					$value['type'] = 0;
				}*/

				$bookingList[$value['type']] = array(
					'name' => $this->__titleForm( $value['type'] ),
					'items' => array(),
				);
			}

			$bookingList[$value['type']]['items'][] = $value;
		}


		$th = '';
		$ths = array();
		$ths[] = array('id'=>'seq', 'name'=>'#', 'cls'=>'td-no');
		$ths[] = array('id'=>'name', 'name'=>'รายการ', 'cls'=>'td-name');
		$ths[] = array('id'=>'price', 'name'=>'', 'cls'=>'td-price');
		$ths[] = array('id'=>'x', 'name'=>'', 'cls'=>'td-x');
		$ths[] = array('id'=>'value', 'name'=>'', 'cls'=>'td-qty');
		$ths[] = array('id'=>'=', 'name'=>'', 'cls'=>'td-x');
		$ths[] = array('id'=>'total', 'name'=>'', 'cls'=>'td-sum');
		foreach ($ths as $key => $value) {
			$th .= '<th class="'.$value['cls'].'">'.$value['name'].'</th>';
		}

		$listsbox = '';
		foreach ($bookingList as $key => $value) {

			$tbody = '';
			foreach ($value['items'] as $i => $item) {
				
				$td = ''; $seq = 0; $total=0; $has=true;
				foreach ($ths as $field) {

					$seq++; $val = '';


					if( $field['id']=='seq' ){
						// $val = "{$seq}.";
					}
					else if( $field['id']=='x' ){
						$val = "x";
					}
					else if( $field['id']=='=' ){
						$val = "=";
					}
					else {
						$val =  isset($item[$field['id']]) ? $item[$field['id']]:'';

						if( is_numeric($val) ){
							$val = number_format($val);

							if( empty($val) && $field['id']=='value'  ) $has = false;
						}
					}

					$td .= '<td class="'.$field['cls'].'">'.$val.'</td>';
				}

				if( $has ){
					$tbody .= '<tr>'.$td.'</tr>';
				}
			}

			if( !empty($tbody) ){

				if( !empty($value['name']) ){
					$listsbox .= '<thead><tr><th class="td-head" colspan="'.count($ths).'">'. $value['name'] .'</th></tr></thead>';
				}

				$listsbox .= '<tbody>'.$tbody.'</tbody>';
			}
		}


		$txt = '<div class="BookingConfirmForm">

			<header>
				<div class="logo"><img src="'.IMAGES.'logo/top-logo.svg" alt="" /></div>
				<h1>ยืนยันการจอง</h1></header>

			<div class="outer">
				<div class="inner">'.

					( $data['status'] == 50
						? '<div class="pam uiBoxRed"><b>จำนวนที่นั่งไม่พอ</b>: คุณสามารถจองรายการนี้ได้ในสถานะ Waitlist</div>'
						: ''
					).

					'<div class="lists">
						<table>'.
							// '<thead><tr>'.$th.'</tr></thead>'.
							
							'<tbody>'.$listsbox.'</tbody>'.
						'</table>
					</div>

					<div style="padding: 20px 8px 2px;">
                        <table data-summary-section="total">
                            <tbody><tr>
                                <td style="padding-right: 10px;">
                                    <div style="font-size: 11px;line-height: 1">Pax</div>
                                    <div style="font-size: 20px;font-weight: bold;color: #4CAF50;text-align: right" class="pax">'.number_format($data['pax']).'</div>
                                </td>
                                <td style="width: 100%"></td>
                                <td style="padding-right: 10px;">
                                    <div style="font-size: 11px;line-height: 1">Discount</div>
                                    <div style="font-size: 20px;font-weight: bold;color: red;text-align: right" class="discount">'.number_format($data['discount']).'</div>
                                </td>
                                <td style="padding-left: 10px;border-left: 1px solid #ccc">
                                    <div style="font-size: 11px;line-height: 1">Total</div>
                                    <div style="font-size: 20px;font-weight: bold;color: #3f51b5;text-align: right" class="total">'.number_format($data['total']).'</div>
                                </td>
                            </tr>
                        </tbody></table>
                    </div>

					<div class="summary">
                        <table class="summary-table"><tbody>

                            <tr>
                                <td style="font-weight: bold;padding-top: 14px;padding-left: 8px;text-align:right">Deposit:</td>
                                <td style="text-align: right;padding-bottom: 10px;padding: 8px 8px 0">
                                    <div style="font-size: 24px;font-weight: bold;" class="deposit">'.number_format($data['deposit']).'</div>
                                </td>
                            </tr>'.

                            ( !empty($data['deposit_date'])
                            	? '<tr><td colspan="2" style="font-size: 14px;padding-right: 8px;text-align: right;">13/09/2018 18:00</td></tr><tr><td colspan="2" style="padding: 4px;"></td></tr>'
                            	: ''
                            ) .

                            '<tr><td colspan="2" style="padding: 4px;"></td></tr>

                            <tr>
                                <td style="font-weight: bold;padding-top: 14px;white-space: nowrap;width: 30px;padding-left: 8px;border-top: 1px solid #fff;text-align:right">Full Payment:</td>
                                <td style="text-align: right;padding: 8px 8px 0;border-top: 1px solid #fff;">
                                    <div style="font-size: 24px;font-weight: bold;" class="fullpayment">'.number_format($data['fullpayment']).'</div>
                                </td>
                            </tr>'.


                            ( !empty($data['fullpayment_date'])
                            	? '<tr><td colspan="2" style="font-size: 14px;padding-right: 8px;text-align: right;">13/09/2018 18:00</td></tr><tr><td colspan="2" style="padding: 4px;"></td></tr>'
                            	: '<tr><td colspan="2" style="padding: 4px;"></td></tr>'
                            ) .

                        '</tbody></table>
                    </div>
				</div>
			</div>

			<footer class="clearfix">

				<div class="lfloat"><button type="button" data-action="close" class="btn btn-link btn-jumbo" style="padding: 0"><span class="btn-text">ยกเลิก</span></button></div>'.

				( $data['status'] == 10
					? '<div class="rfloat"><button type="button" class="btn btn-blue btn-jumbo" data-action="submit"><span class="btn-text">ยืนยัน</span></button></div>'
					: ''
				).

				( $data['status'] == 50
					? '<div class="rfloat"><button type="button" class="btn btn-orange btn-jumbo" data-action="submit"><span class="btn-text">Waitlist</span></button></div>'
					: ''
				).
				
			'</footer>

		</div>';
		return $txt;
	}


	public function __titleForm($id)
	{
		
		$a = array(
			'ราคา', 
			'', 
			'', 
			'คอมมิชชั่น', 
			'ส่วนลด', 
			'<i class="icon-info-circle mrs fc-red"></i><span>บวกราคาเพิ่ม</span>', 
			'รายการเพิ่มเติม',
			'' // Sing Charge
		);

		return $a[$id];
	}



	public function waitlistForm( $data=array() ) {
		
		$txt = '<div class="model-waitlistForm">

			<header><h1>จำนวนที่นั่งไม่พอ</h1></header>
			<div class="outer mvl">
				<div>คุณต้องการจะจองต่อไปในสถานะ Waitlist ใช่หรือไม่</div>
			</div>
			<footer class="clearfix">
				<div class="lfloat"><button type="button" data-action="close" class="btn btn-link" style="padding: 0"><span class="btn-text">ยกเลิก</span></button></div>
				<div class="rfloat"><button type="button" class="btn btn-blue" data-action="submit"><span class="btn-text">Waitlist</span></button></div>
				
			</footer>

		</div>';
		return $txt;
	}



	public function travelerTable($data, $options=array())
	{

		$options = array_merge( array(

			'action' => URL.'booking/traveler/save',

		), $options );
		
		// roomList
		$roomList = array();
		$roomList[] = array('quota'=>2, 'id'=>'twin', 'label'=>'Twin', 'color'=>'#f6bec9');
		$roomList[] = array('quota'=>2, 'id'=>'double', 'label'=>'Double', 'color'=>'#87daff');
		$roomList[] = array('quota'=>3, 'id'=>'triple', 'label'=>'Triple', 'color'=>'#cddc39');
		$roomList[] = array('quota'=>3, 'id'=>'tripletwin', 'label'=>'Triple Twin', 'color'=>'#fdf080');
		$roomList[] = array('quota'=>1, 'id'=>'single', 'label'=>'Single', 'color'=>'#ffcb7d');

		
		// roomFields
		$roomFields = array();
		$roomFields[] = array('id'=>'_seq', 'name'=>'','label'=>'#', 'cls'=>'td-seq');
		// $roomFields[] = array('id'=>'_room', 'name'=>'','label'=>'Room');
		$roomFields[] = array('type'=>'prefix', 'id'=>'', 'name'=>'prename','label'=>'คำนำหน้าชื่อ*', 'cls'=>'td-input-wrap td-prefix');
		$roomFields[] = array('type'=>'fullname', 'id'=>'', 'name'=>'fname','label'=>'ชื่อ (อังกฤษ)*');
		$roomFields[] = array('type'=>'fullname', 'id'=>'', 'name'=>'lname','label'=>'สกุล (อังกฤษ)*');

		$roomFields[] = array('type'=>'name', 'id'=>'', 'name'=>'name_thai','label'=>'ชื่อ-สกุล (ไทย)*');

		$roomFields[] = array('type'=>'select', 'id'=>'', 'name'=>'sex','label'=>'เพศ*', 'items' => array(0=>array('id'=>1, 'name'=>'ชาย'), array('id'=>2, 'name'=>'หญิง') ), 'cls'=>'td-radio');
		$roomFields[] = array('id'=>'', 'name'=>'country','label'=>'จังหวัด*');
		$roomFields[] = array('id'=>'', 'name'=>'nationality','label'=>'สัญชาติ*');
		$roomFields[] = array('id'=>'', 'name'=>'address','label'=>'ที่อยู่ในประเทศ');
		$roomFields[] = array('type'=>'date', 'id'=>'', 'name'=>'birthday','label'=>'วัน/เดือน/ปี เกิด', 'cls'=>'td-date');
		$roomFields[] = array('id'=>'', 'name'=>'placeofbirth','label'=>'จัดหวัดที่เกิด');
		$roomFields[] = array('id'=>'', 'name'=>'career','label'=>'อาชีพ');


		$roomFields[] = array('id'=>'', 'name'=>'passportno','label'=>'Passport No.');
		$roomFields[] = array('type'=>'date', 'id'=>'', 'name'=>'expire','label'=>'Expire');
		// $roomFields[] = array('id'=>'', 'name'=>'','label'=>'File');
		// $roomFields[] = array('id'=>'', 'name'=>'','label'=>'Upload');
		$roomFields[] = array('id'=>'', 'name'=>'place_pp','label'=>'สถานที่ออก PP');
		$roomFields[] = array('type'=>'date', 'id'=>'', 'name'=>'date_pp','label'=>'วันที่ออก PP', 'cls'=>'td-date');
		$roomFields[] = array('id'=>'', 'name'=>'remark','label'=>'หมายเหตุ');




		$listsHeader = array();
		$listsHeader[] = array('label'=>'รหัสการจอง', 'value'=>'<span class="mrm fwb">'.$data['code'].'</span>'.'<span class="ui-status" style="background:'.$data['status_arr']['color'].'">'.$data['status_arr']['name'].'</span>');

		$listsHeader[] = array('label'=>'ชื่อลูกค้า', 'value'=>$data['cus_name'], 'type'=>'input', 'name'=>'cus_name');
		$listsHeader[] = array('label'=>'เบอร์โทรลูกค้า', 'value'=>$data['cus_tel'], 'type'=>'input', 'name'=>'cus_tel');


		$listsHeader_str = '';
		foreach ($listsHeader as $key => $value) { 


			$type = isset($value['type']) ? $value['type']: '';
			$val = '';

			if( $type=='input' ){
				$val = '<input type="text" class="inputtext" name="'.$value['name'].'" value="'.$value['value'].'" autocomplete="off" />';
			}
			else{
				$val = $value['value'];
			}


			

			$listsHeader_str .= '<tr>
				<td style="padding: 5px;font-weight: bold;color: #666">'.$value['label'].'</td>
				<td>'.$val.'</td>
			</tr>';

		}

		$thead = '<th class=""></th>';
		foreach ($roomFields as $key => $value) {
			$thead .= '<th class="td-label">'.$value['label'].'</th>';
		}
		$thead = '<thead><tr>'.$thead.'</tr></thead>';


		$tbody = ''; $roomNo = 0;
		foreach ($roomList as $i => $item) { 
			$roomNo++;

			$tbody .= '<tbody><td style="padding: 0;" colspan="'.(count($roomFields)+1).'"></td></tbody>';

			$tbody .= '<tbody>';

			$_seq = 0;
			for ($i=0; $i < $item['quota']; $i++) {

				$tbody .= '<tr>';

				$_seq++;
				if($_seq==1){
					$tbody .= '<td class="td-room-type" rowspan="'.$item['quota'].'" style="background:'.$item['color'].';"><div>'.$item['label'].'</div></td>';
				}


				foreach ($roomFields as $key => $value) {

					$_data = array();

					if( !empty($data['travelerList']) ){
						foreach ($data['travelerList'] as $val) {
							if( $roomNo==$val['room_no'] && $_seq==$val['room_seq'] ){
								$_data = $val;
							}
						}
					}


					$val = '';
					$type = isset($value['type'])? $value['type']: 'text';
					$name = 'room['.$roomNo.']['.$_seq.']['.$value['name'].']';
					$cls = isset($value['cls'])? $value['cls']: '';


					$_val = !empty($_data["room_{$value['name']}"]) ? $_data["room_{$value['name']}"]: '';



					if( $value['id']=='_seq' ){
						$val = $_seq;
					}elseif( $type=='select' ){

						$select = '<option value="">-</option>';
						foreach ($value['items'] as $val) {

							$selected = $_val==$val['id'] ? ' selected':'';

							$select .= '<option'.$selected.' value="'.$val['id'].'">'.$val['name'].'</option>';
						}

						$val = '<select name="'.$name.'">'.$select.'</select>';

					}elseif( $type=='date' ){
						$val = '<input type="date" class="inputtext" name="'.$name.'" value="'.$_val.'" />';

					}else{
						$val = '<input type="text" class="inputtext" name="'.$name.'" value="'.$_val.'" />';
					}


					// 
					$tbody .= '<td class="td-input '.$cls.'" style="background:'.$item['color'].';">'.
						$val.
						'<input type="hidden" class="inputtext" value="'.$item['id'].'" name="room['.$roomNo.']['.$_seq.'][type]" />'.
					'</td>';
				}


				$tbody .= '</tr>';


			}

			$tbody .= '</tbody>';
		}


		$render = '<form action="'.$options['action'].'" method="post" class="pal" data-action="inlineSubmit" style="padding: 5px;border-radius: 2px;margin: 20px 10px;border: 1px solid #ccc;">'.
	
			'<input type="hidden" name="booking_id" value="'.$data['id'].'" autocomplete="off">'.


			'<header class="">'.
				'<table style="width: auto;"><tbody>'.$listsHeader_str.'</tbody></table>'.
			
				'<div style="margin-top: 12px">'.

					'<table>
						<tr>
							<td><button type="button" class="btn btn-blue" data-toggle="modal"><i class="icon-upload"></i><span class="mls">อัพโหลดไฟล์พาสปอร์ต</span></button></td>

							<td style="white-space: nowrap;padding-left: 10px">
								<label class="radio"><input type="radio" name="passport_status" value="1"'.($data['booking_passport']==3 ? '':' checked').'><span>ยังไม่สมบูรณ์</span></label>
							</td>
							<td style="white-space: nowrap;padding-left: 10px">
								<label class="radio"><input type="radio" name="passport_status" value="3"'.($data['booking_passport']==3 ? ' checked':'').'><span>สมบูรณ์แล้ว</span></label>
							</td>
							<td style="width: 100%"></td>

							<td style="white-space: nowrap;padding-left: 10px"><button type="submit" class="btn btn-primary"><span>บันทึก</span></button></td>
						</tr>
					</table>'.
				'</div>'.

			'</header>'.


			'<section style="border-top: 1px solid #ccc; margin: 10px 0 0;">'.
				'<div class="roomLists">'.
					'<div class="roomLists-items">'.
						'<div style="padding: 5px">'.
							'<div style="overflow: auto;">'.
								'<table class="">'. $thead.$tbody.'</table>'.
							'</div>'.
						'</div>'.
					'</div>'.
				'</div>'.
			'</section>'.


			'<div class="clearfix">
				<div class="rfloat">
					<button type="submit" class="btn btn-primary"><span>บันทึก</span></button>
				</div>
			</div>'.

		'</form>';

		return $render;
	}


	
	// Verify Form
	public function verifyForm(&$cache, $postData, $options)
	{
		$cache = array(
            'options' => $options,
            'detail' => array(),
            'sum' => array(
                'pax'=>0,				// ticket
                'landVal'=>0,			// ผู้เดินทางทั้งหมด land
                'comVal'=>0, 			// นับค่าคอม

                'subtotal'=>0,
                'discount'=>0,
                'total'=>0,				

                'commission_val'=>0, 	// type= 3
                'discount_val'=>0, 		// type= 4
                'additional_val' => 0,	// type= 5
                'extralist_val' => 0,	// type= 6 
                'promotion_val'=>0,		// type= 8
                'discount_extra' => 0,	// type= 9
                
                'com_agency_company' => 0,
                'com_agency' => 0,
            ),
        );

		$this->verifyForm__Basic( $cache, $postData );
        $this->verifyForm__Traveler( $cache, $postData['traveler'] );	// type 0
        $this->verifyForm__InfantandJoinland( $cache, $postData ); 		// type 1, 2 
        $this->verifyForm__List( $cache, $postData ); 					// รายการอื่นๆ
        $this->verifyForm__ExtraLest( $cache, $postData['extra']); 		// รายการพิเศษ
        $this->verifyForm__discountExtra( $cache, $postData );


       	if( empty($cache['detail']) ){
        	$cache['error'] = 1;
        	$cache['message'] = 'ยังไม่มีรายการสินค้า';
        }

        $bookingPost = array(

            'user_id' => trim($postData['sales']),
            'agen_id' => trim($postData['agent']),
            'book_cus_name' => trim($postData['book_cus_name']),
            'book_cus_tel' => trim($postData['book_cus_tel']),

            'book_comment' => trim($postData['book_comment']),
            'remark' => trim($postData['remark']),

        );
        

        $room_of_types = $options['room_of_types'];

        $cache['sum']['room_pax'] = 0;
        foreach ($options['room_of_types'] as $key => $value) {
        	

        	$val = 0;
        	if( !empty($postData['room'][$value['id']]) ){
        		$val = $postData['room'][$value['id']];
        	}

        	$cache['sum']['room_pax'] += $val*$value['quota'];

	        $bookingPost["book_room_{$value['id']}"] = $val;
        }// end for: type room

        // echo  print_r($postData); die;
        // Sing Charge // type= 7
        if( !empty($postData['room']['single']) ){

        	$val = $postData['room']['single'];
        	$price = $options['single_charge'];

            $total = $price*$val;
            $cache['detail'][] = array(
                'type' => 7,
                'name' => 'Sing Charge',
                'value' => $val,
                'price' => $price,
                'total' => $total,
                'seq' => 1,
            );
            $cache['sum']['subtotal'] += $total;
        }


        $cache['sum']['total'] = $cache['sum']['subtotal'] - $cache['sum']['discount'];
        $cache['bookingPost'] = array_merge(array(

        	'book_total' => $cache['sum']['subtotal'],
            'book_discount' => $cache['sum']['discount'],
            'book_amountgrandtotal' => $cache['sum']['total'],

            'book_extralist_total' => $cache['sum']['extralist_val'],

            'book_com_agency_company' => $cache['sum']['com_agency_company'],
            'book_com_agency' => $cache['sum']['com_agency'],

            'book_pax' => $cache['sum']['pax'],
            // 'book_landVal' => $cache['sum']['landVal'],
            // 'book_comVal' => $cache['sum']['comVal'],

        ), $bookingPost);


        // เก็บรายการไว้ใน database เก่า
        $cache['bookingList'] = array();
        foreach ($cache['detail'] as $key => $value) {
        	if( in_array($value['type'], array(0,1,2)) ){
        		$cache['bookingList'][] = $value;
        	}
        }

	}
	public function verifyForm__Basic(&$arr, $dataPost)
	{
		$verify = array();
        $verify['sales'] = array('err'=>'กรุณาเลือก Sale Contact');
        $verify['company'] = array('err'=>'ใส่ข้อมูลในช่องนี้');
        $verify['agent'] = array('err'=>'ใส่ข้อมูลในช่องนี้');
        $verify['book_cus_name'] = array('err'=>'ใส่ชื่อลูกค้า');
        $verify['book_cus_tel'] = array('err'=>'ใส่เบอร์โทรลูกค้า');

        foreach ($verify as $key => $value) {
            if( isset($dataPost[$key]) ){

                if( empty($dataPost[$key]) && $value['err'] ){
                    $arr['error'][$key] = $value['err'];
                }
            }
        }
	}
	public function verifyForm__Traveler(&$arr, $dataPost )
	{
		$priceValues = $arr['options']['price_values'];
		$values = array();
		foreach ($dataPost as $key => $value) {
			$values[] = $value;
		}

		// echo '<pre>'; print_r($dataPost); echo '</pre>'; die;
		$seq = 0;
		foreach ($priceValues as $key => $value) {
			$seq ++;

			$val = 0;
			foreach ($values as $i => $post) {
				if( $key==$i ){
					$val = $post;
					continue;
				}
			}
			$price = intval(isset($value['value'])? $value['value']: 0);
			$val = intval($val);
			$total = $val*$price;

			$arr['sum']['pax'] += $val;
			$arr['sum']['landVal'] += $val;
			$arr['sum']['comVal'] += $val;
			$arr['sum']['subtotal'] += $total;

			$arr['detail'][] = array(
				'type' => 0,
				'seq' => $seq,
				'key' => isset($value['key'])? $value['key']: null,
				'name' => $value['name'],
				'value' => $val,
				'price' => $price,
				'total' => $total
			);
		}
	}
	public function verifyForm__InfantandJoinland(&$arr, $postData)
	{
		$busOpt = $arr['options'];
		foreach (array('infant', 'joinland') as $key) {
            
            // if( empty($postData['traveler'][$key]) ) continue;
            switch ($key) {
                case 'infant': $type=1; $_key = 'per_price_4'; break;
                case 'joinland': $type=2; $_key = 'per_price_5'; break;
            }

            $val = !empty($postData['traveler'][$key]) ? $postData['traveler'][$key]: 0;
            $price = isset($busOpt[$key])? $busOpt[$key]: 0;
            $total = $val*$price;

            if( $key=='infant' ){
            	$arr['sum']['landVal'] += $val;
            }

            if( $key=='joinland' ){
            	$arr['sum']['comVal'] += $val;
            }

            $arr['sum']['subtotal'] += $total;

            // joinland
            $arr['detail'][] = array(
                'type' => $type,
                'name' => ucfirst($key),
                'value' => $val,
                'key' => $_key,
                'price' => $price,
                'total' => $total,
            );
        }
	}
	public function verifyForm__ExtraLest(&$arr, $postExtra)
	{	
		// echo '<pre>'; print_r($postExtra); echo '</pre>'; die;

		$seq = 0;
		for ($i=0; $i < count($postExtra['name']); $i++) {
			
			if( empty($postExtra['name'][$i]) || empty($postExtra['qty'][$i]) ) continue;
            $seq ++;

            $qty = !empty($postExtra['qty'][$i]) ? $postExtra['qty'][$i]: 0;
            $qty = intval(str_replace(',', '', $qty));

            $price = intval(str_replace(',', '', $postExtra['price'][$i]));
            $total = $price*$qty;

            $arr['sum']['subtotal'] += $total;
            $arr['sum']['extralist_val'] += $total;

            $item = array(
            	'type' => 6,
                'name' => $postExtra['name'][$i],
                'price' => $price,
                'value' => $qty,
                'total' => $total,
                'seq' => $seq,
            );

             if( isset($postExtra['id'][$i]) ){
                $item['key'] = $postExtra['id'][$i];
            }

			$arr['detail'][] = $item;

		}
	}
	public function verifyForm__List(&$arr, $postExtra)
	{	
		$busOptPrice = $arr['options'];
		foreach (array('commission', 'discounts', 'price_additional', 'promotion') as $obj) {
            
            switch ($obj) {
                case 'commission': $type=3; break;
                case 'discounts': $type=4; break;
                case 'price_additional': $type=5; break;
                case 'promotion': $type=8; break;
            }
            
            if( !empty($busOptPrice[$obj]) ){
                
                $seq = 0;
                foreach ($busOptPrice[$obj] as $key => $value) {
                    $seq++;

                    $countVal = 0;

                    if( $obj=='price_additional' ){
                    	$countVal = $arr['sum']['landVal'];
                    }
                    else{
                    	$countVal = $arr['sum']['comVal'];
                    }


                    $total = $value['value']*$countVal;
                    

                    $arr['detail'][] = array(
                        'type' => $type,
                        'name' => $value['name'],
                        'value' => $countVal,
                        'key' => isset($value['key']) ? $value['key']: '',
                        'price' => $value['value'],
                        'total' => $total,
                        'seq' => $seq,
                    );
                    
                    if( isset($value['key']) ){
                        if( $value['key']=='per_com_company_agency' ){
                            $arr['sum']['com_agency_company'] += $total;
                        }

                        if( $value['key']=='per_com_agency' ){
                            $arr['sum']['com_agency'] += $total;
                        }
                    }

                    if( in_array($obj, array('commission', 'discounts', 'promotion')) ){

                    	if($obj=='commission'){
                    		$arr['sum']['commission_val'] += $total;
                    	}

                    	if($obj=='promotion'){
                    		$arr['sum']['promotion_val'] += $total;
                    	}

                    	if($obj=='discounts'){
                    		$arr['sum']['discount_val'] += $total;
                    	}

                        
                        $arr['sum']['discount'] += $total;
                    }
                    else{
                    	if($obj=='additional_val'){
                    		$arr['sum']['additional_val'] += $total;
                    	}

                        $arr['sum']['subtotal'] += $total;
                    }
                }

            }
        }
	}
	public function verifyForm__discountExtra(&$arr, $postData)
	{
		if( !empty($postData['discount_extra']) ){

			$discountExtra = intval($postData["discount_extra"]);

            $arr['sum']['discount_extra'] = $discountExtra;
            $arr['sum']['discount'] += $discountExtra;

            $arr['detail'][] = array(
				'type' => 9,
				'seq' => 1,
				'name' => 'ลดพิเศษ',
				'value' => 1,
				'price' => $discountExtra,
				'total' => $discountExtra
			);
        }
	}

}