<?php

class form_Fn extends Fn{

	public function address( $data=array(), $options=null ) {

		if( $options===null )  $options = $data;

		$options = array_merge( array(
			'field_name' => 'address',
			'field_first_name' => '',
			'field_last_name' => '',
			'fields' => array()
		), $options );

		$name = !empty($options['field_name'])? $options['field_name']:'address';

		if( !empty($options['field_first_name']) ){
			$name = $options['field_first_name'].$name;
		}

		if( !empty($options['field_last_name']) ){
			$name .= $options['field_last_name'];
		}

		$city = array(
            'id' => 'address_city', 
            'name' => $name.'[city]', 
            'label' => 'จังหวัด',
            'value' => !empty($data['city']) ? $data['city']:''
        );
		if( !empty($options['city'])){
            if( is_array($options['city']) ){
            	$city['type'] = 'select';
            	$city['options'] = $options['city'];
            }
        }
        
        $fields = array( 0=> 
            array( 0 => 
                array(
                    'id' => 'address_street', 
                    'name' => $name.'[street]', 
                    'label' => 'Street',
                    'value' => !empty($data['street']) ? $data['street']:''
                ),
            ),

            array( 0 => 
                array(
                    'id' => 'address_city', 
                    'name' => $name.'[city]', 
                    'label' => 'City',
                    'value' => !empty($data['city']) ? $data['city']:''
                ),
                array(
                    'id' => 'address_district', 
                    'name' => $name.'[district]', 
                    'label' => 'State',
                    'value' => !empty($data['district']) ? $data['district']:''
                ),
                array(
                    'id' => 'address_amphur', 
                    'name' => $name.'[amphur]', 
                    'label' => 'Zip',
                    'value' => !empty($data['amphur']) ? $data['amphur']:''
                ),
            ),

            array( 0 => 
                array(
                    'id' => 'address_zip', 
                    'name' => $name.'[zip]', 
                    'label' => 'Country',
                    'value' => !empty($data['zip']) ? $data['zip']:''
                ),
            ),
        );

        return '<div class="table-address-wrap">'.  $this->__address( $fields ) .'</div>';
	}
	private function __address($data) {
		$str = '';
        foreach ($data as $rows) {

            $str .= '<table cellspacing="0" class="table-address"><tr>';
            // cell
            foreach ($rows as $cell => $value) {
                
                $type = isset($value['type']) ? $value['type'] : 'text';
                $id = isset($value['id']) ? $value['id'] : '';
                $name = isset($value['name']) ? $value['name'] : $id;
                $label = isset($value['label']) ? $value['label'] : '';
                
                if($type=='select'){
                    
                    $option = '<option value="">-</option>';
                    $val = isset($value['value']) ? $value['value'] : '';
                    foreach ($value['options'] as $data) {

                        $active = $val==$data['id'] ? ' selected="1"':'';
                        
                        $option .= '<option'.$active.' value="'.$data['id'].'">'.$data['name'].'</option>';
                    }

                    $input = '<select class="inputtext" id="'.$id.'" name="'.$name.'">'.$option.'</select>';
                }
                else{

                    $val = isset($value['value']) ? ' value="'.$value['value'].'"':'';
                    $input = '<input id="'.$id.'" autocomplete="off" class="inputtext" type="text" name="'.$name.'"'.$val.'>';
                }

                $str .= '<td class="label"><label for="'.$id.'">'.$label.'</label></td>';
                $str .= '<td class="data">'.$input.'</div>';

            }

            $str .= '</tr></table>';
        }

        return $str;
	} 

	public function fullname( $data=array(), $options=null ) {
	
		$options = array_merge( array(
			'field_first_name' => '',
			'field_last_name' => '',
			'fields' => array(),
			'prefix_name' => array()
		), $options);


		$fields = array_merge( array( 
			'prefix_name' => array('id'=>'prefix_name','label'=> Translate::Val('Prefix Name'),'type'=>'select', 'options'=>$this->_prefixName($options['prefix_name']), 'addClass'=>'input-prefix'), 
			'first_name'  => array('id'=>'first_name','label'=> Translate::Val('First Name') ), 
			'last_name'  => array('id'=>'last_name','label'=> Translate::Val('Last Name') ), 
			'nickname'  => array('id'=>'nickname','label'=> Translate::Val('Nickname') ,'addClass' => 'input-nickname')
		), $options['fields'] );

		$_fields = array();
		foreach ($fields as $key => $field) {

			if( isset($field['disabled']) || empty($field['id']) ) continue;

			if( !empty($options['field_first_name']) ){
				$field['id'] = $options['field_first_name'].$field['id'];
			}

			if( !empty($options['field_last_name']) ){
				$field['id'] .= $options['field_last_name'];
			}

			if( !empty($data[ $key ]) ){
				$field['value'] = $data[ $key ];
			}

			$_fields[] = $field;
		}

		return '<div class="u-table-wrap u-table-fullname">'. $this->uTableCell( $_fields) .'</div>';
	}
	private function _prefixName( $options=array() ) {
		
        $a['Mr.'] = array('id'=>'Mr.', 'name'=> Translate::Val('Mr.') );
        $a['Mrs.'] = array('id'=>'Mrs.', 'name'=> Translate::Val('Mrs.') );
        $a['Ms.'] = array('id'=>'Ms.', 'name'=> Translate::Val('Ms.') );

        return array_merge($a, $options);
	}

	public function birthday( $data=null, $options=array() ) {

		$options = array_merge( array(
			'field_first_name' => 'birthday',
			'field_last_name' => '',
			'end_year' => 18
		), $options);

		if( $data==null ) $data = $options;

		$days[] = array('id'=>'00', 'name'=> '--'.Translate::Val('Date').'--' );
		for ($i=1; $i <= 31; $i++) { 
			$d = $i < 10 ? "0{$i}":$i;
		    $days[] = array('id'=>$d, 'name'=> $i);
		}

		$fields[] = array( 
		    'id' => $options['field_first_name'] . '_date',
		    'name' => $options['field_first_name'] . '[date]', 
		    'label' => Translate::Val('Day'),
		    'type' => 'select',
		    'options' => $days,
		    'value' => !empty($data['birthday']) ? date('j', strtotime($data['birthday']) ):''
		);

		$months[] = array('id'=>'00', 'name'=> '--'.Translate::Val('Month').'--' );
		for ($i=1; $i <= 12; $i++) { 
			$m = $i < 10 ? "0{$i}":$i;
		    $months[] = array('id'=>$m, 'name'=> $this->q('time')->month( $i, 0, $this->lang->getCode() ));
		}
		$fields[] = array( 
		    'id' =>  $options['field_first_name'] . '_month',
		    'name' => $options['field_first_name'].'[month]', 
		    'label' => Translate::Val('Month'),
		    'type' => 'select',
		    'options' => $months,
		    'value' => !empty($data['birthday']) ? date('n', strtotime($data['birthday']) ):''
		);

		$years[] = array('id'=>'0000', 'name'=> '--'.Translate::Val('Year').'--');
		$y = date('Y') - $options['end_year'];
		$i = 1;
		do {
		    $years[] = array('id'=>$y, 'name'=>$y );
		    $y--;  $i++;
		} while ($i <= 70);

		$fields[] = array( 
		    'id' =>  $options['field_first_name'] . '_year', 
		    'name' => $options['field_first_name'].'[year]', 
		    'label' => Translate::Val('Year'),
		    'type' => 'select',
		    'options' => $years,
		    'value' => !empty($data['birthday']) ? date('Y', strtotime($data['birthday']) ):''
		);

		return '<div class="u-table-wrap u-table-birthday">' . $this->uTableCell($fields) .'</div>';
	}


	/*
		$type: email, phone, social
		data: 
	*/
	public function contacts($type, $data=array(), $options=array()) {
		
		$options = array_merge( array(
			'field_first_name' => '',
			'field_last_name' => '',
			'field_label' => '',
			'has_add' => true,
		), $options);

		$field_name = !empty($options['field_first_name'])? $options['field_first_name']: $type;

		if( !empty($options['field_last_name']) ){
			$field_name .= $options['field_last_name'];
		}

		$fieldset = '';
		foreach ($data as $key => $value) {
			$fieldset .= $this->_contacts( $type, $options, $field_name, $value['name'], $value['value'] );
		}

		if( empty($data) ){
			$fieldset .= $this->_contacts( $type, $options, $field_name );
		}

		return '<fieldset id="'. str_replace(array('[',']'), array('_', ''), $field_name).'_fieldset" class="form-field clearfix form-field-'.$type.'" data-plugins="formcontacts">'.
		    $fieldset.
		'</fieldset>';
	}
	public function _contact_label_email() {
		$labels = array();
		$labels[] = array('text'=> Translate::Val('Personal Email') );
		$labels[] = array('text'=> Translate::Val('Work Email') );
		$labels[] = array('text'=> Translate::Val('Other Email') );

		return $labels;
	}
	public function _contact_label_phone() {
		$labels = array();
		$labels[] = array('text'=> Translate::Val('Mobile Phone') );
		$labels[] = array('text'=> Translate::Val('Work Phone') );
		$labels[] = array('text'=> Translate::Val('Home Phone') );
		$labels[] = array('text'=> Translate::Val('Other phone') );
		return $labels;
	}
	public function _contact_label_social() {
		$labels = array();
		$labels = array();
		$labels[] = array('text'=> Translate::Val('Line ID') );
		$labels[] = array('text'=> Translate::Val('Facebook') );
		$labels[] = array('text'=> Translate::Val('Other') );
		return $labels;
	}
	public function _contacts($type, $options=array(), $name='', $label='', $value='' ) {
		
		$labelselect = '';
		foreach ($this->{"_contact_label_{$type}"}() as $val) {
			$active = $label == $val['text'] ? ' selected="1"':'';
        	$labelselect .='<option'.$active.' value="'.$val['text'].'">'.$val['text'].'</option>';
    	}

    	if( empty($name) ) $name = 'contacts['.$type.']';

    	$actions = !empty($options['has_add']) 
    		? '<div class="controls-actions">'.
    			'<a class="btn-add js-add-field"><i class="icon-plus"></i><span>เพิ่ม</span></a>'.
    			'<a class="btn-add js-remove-field remove"><i class="icon-remove"></i><span>ลบ</span></a>'.
    		  '</div>'
    		:'';

		return '<div class="control-group">'.
	        '<label class="control-label">'.
	            '<select name="'.$name.'[name][]" class="labelselect">'.$labelselect.'</select>'.
	        '</label>'.
	        '<div class="controls">'.
	            '<input class="inputtext js-input" autocomplete="off" type="text" name="'.$name.'[value][]" value="'.$value.'" />'.
	            '<div class="notification"></div>'.
	            $actions.
	        '</div>'.
	    '</div>';
	}


	/* -- radio Button Group */
	public function radioButtonGroup( $options=array(), $checked='', $name='' ) {

		if( empty($checked) && !empty($options[0]['value']) ){
			$checked = $options[0]['value'];
		}

		$li = '';
		foreach ($options as $key => $value) {

			$_checked = $checked==$value['value'] ? ' checked':'';
			$label = isset($value['label']) ? $value['label']:$value['value'];
			$cls = 'btn';
			if( !empty($_checked) ){
				$cls .= ' btn-blue active';
			}

			$li.='<div class="'.$cls.'"><label class="radio hidden_elem"><input'.$_checked.' type="radio" name="'.$name.'" value="'.$value['value'].'" autocomplete="off"></label><span>'.$label.'</span></div>';
		}

		return '<div class="group-btn" data-plugins="radioButtonGroup">'. $li. '</div>';
	}


	public function checkboxList( $data=array(), $options=array() ) {
		
		$options = array_merge( array(
			'checked' => '',
			'name' => '',
		), $options);
		$li = '';
		foreach ($data as $key => $value) {
			
			$checked = $options['checked']==$value['id'] ? ' checked':'';
			

			$cls = '';
			if( !empty($value['addClass']) ){
				$cls .= !empty($cls) ? ' ':'';
				$cls .= $value['addClass'];
			}

			$cls = !empty($cls) ? ' class="'.$cls.'"': '';
			$li.='<li'.$cls.'><label class="checkbox"><input'.$checked.' type="checkbox" name="'.$options['name'].'" value="'.$value['id'].'" autocomplete="off"><span class="mls">'.$value['name'].'</span></label></li>';
		}

		return '<ul class="ui-checkbox-list">'. $li. '</ul>';

	}


	// Departure Flight
	public function tr_flight($data=array(), $type='departure')
	{

		$labelText = '';
		switch ($type) {
			case 'departure':$labelText = 'เที่ยวบินขาไป'; break;
			case 'arrival':$labelText = 'เที่ยวบินขากลับ'; break;
		}
		return '<tr>'.
	            	
            '<td class="td-label"><span class="text">'.$labelText.'</span></td>'. 


            '<td class="td-input">'.
                '<input type="text" class="inputtext" placeholder="" autocomplete="off" name="flight['.$type.'][no][]" value="'.(!empty($data['no'])? $data['no']: '').'">'.
            '</td>'.
            '<td class="td-route">'.

            	'<table><tbody>'.

            		'<td class="td-route-input"><input type="text" class="inputtext" placeholder="" autocomplete="off" name="flight['.$type.'][from][]" value="'.(!empty($data['from'])? $data['from']: '').'"></td>'.

               		'<td class="td-x">-</td>'.
               		'<td class="td-route-input"><input type="text" class="inputtext" placeholder="" autocomplete="off" name="flight['.$type.'][to][]" value="'.(!empty($data['to'])? $data['to']: '').'"></td>'.

            	'</tbody></table>'.
            '</td>'.
            '<td class="td-time">'.
                '<input type="text" class="inputtext" placeholder="" autocomplete="off" name="flight['.$type.'][time][]"" value="'.(!empty($data['time'])? $data['time']: '').'">'.
            '</td>'.
            '<td class="td-action">'.
            	'<button type="button" class="btn" data-action="add"><i class="icon-plus"></i></button>'.
            	'<button type="button" class="btn" data-action="remove"><i class="icon-remove"></i></button>'.
            '</td>'.
        '</tr>';
	} 

	//
	public function table_flight($options=array())
	{

		$departure = '';
		if( !empty($options['departure']) ){
			foreach ($options['departure'] as $key => $value) {
				$departure .= $this->tr_flight($value);
			}
		}
		else{
			$departure = $this->tr_flight();
		}


		$arrival = '';
		if( !empty($options['arrival']) ){
			foreach ($options['arrival'] as $key => $value) {
				$arrival .= $this->tr_flight($value, 'arrival');
			}
		}
		else{
			$arrival = $this->tr_flight(array(), 'arrival');
		}

		return '<div class="table-flight-wrap"><table class="table-flight">'.


			'<thead>'.
				'<tr>'.
					'<th class="td-label"></th>'. 
					'<th class="td-label">Flight No.</th>'. 
					'<th class="td-label tac">เส้นทางไป-กลับ</th>'. 
					'<th class="td-label">เวลา</th>'. 
					'<th class="td-action"></th>'. 
				'</tr>'.
			'</thead>'.

			'<tbody class="table-flight-box" data-type="departure">'.$departure.'</tbody>'.
            '<tbody class="divider"><tr><td colspan="6"><hr /></td></tr></tbody>'.
            '<tbody class="table-flight-box" data-type="arrival">'.$arrival.'</tbody>'.
        
        '</table>';
	}

	public function imageCover($options=array())
	{	
		
		if( !is_array($options) ){
			$options['name'] = $options;
		}

		$options = array_merge( array(
			'name' => 'file1',
			'accept' => 'image/jpeg,image/png',
			'width' => 230,
			'height' => 230,
			'size' => 'auto',

			'dropzoneText' => 'แนบไฟล์รูป',
			
		), $options);

		if( !isset($options['dropzoneSubtext']) ){
			$options['dropzoneSubtext'] = "{$options['width']}x{$options['height']}";
		}
		

		$attr = '';
		$cls = 'uiCoverImageContainer preview-image has-empty';
		if( isset($options['src']) ){
			// $cls .= ' has-image';

			// $attr = ' onload="PreviewImage.load(this, '. $options['src'] .')"';
		}
		else{
			// $cls .= ' has-empty';
		}

		// 
		return '<div data-plugin="input__image" data-options="'.$this->_stringify( $options ).'" class="'.$cls.'"'.$attr.' data-width="'.$options['width'].'" data-height="'.$options['height'].'" style="width:'.$options['width'].'px;height:'.$options['height'].'px">'.

		'<div class="uiCoverImage_empty">'.
			'<div class="v-center-outer"><div class="v-center-inner">'.

				'<div class="dropzone-icon"></div>'.

				'<div class="dropzone-title">'.
					'<h4 class="dropzone-text">'.$options['dropzoneText'].'</h4>'.
					'<p class="dropzone-subtext">'.$options['dropzoneSubtext'].'</p>'.
				'</div>'.

			'</div></div>'.

		'</div>'.

		'<div class="uiCoverImage_image" role="preview"></div><div class="uiCoverImage_action">'.


			'<a href="javascript:void(0)" data-action="trigger"><i class="fa fa-camera"></i></a>'.
			'<a href="javascript:void(0)" data-action="remove"><i class="fa fa-remove"></i></a>'.

		'</div><div class="uiCoverImage_overlay"><input role="button" type="file" accept="'.$options['accept'].'" name="'.$options['name'].'"></div><div class="uiCoverImage_loaderspin"><div class="loader-spin-wrap"><div class="loader-spin"></div></div></div></div>';
	}


	public function table_code($data)
	{
		
		return '<div class="table-code-wrap" data-plugin="tableCode">'.

			'<div class="row no-gutters table-code-input"><tbody><tr>'.

				'<div class="col-auto td-input"><input id="code-route" class="inputtext disabled" autocomplete="off" type="text" value="" disabled><span class="overlay"></span></div>'.
				'<div class="col-auto td-input"><input id="code" class="inputtext" autocomplete="off" type="text" name="code" value="'.( !empty($data['sku'])? $data['sku']:'').'" maxlength="10"><span class="overlay"></span></div>'.
				'<div class="col-auto td-x">-</div>'.
				'<div class="col-auto td-input"><input id="code-air" class="inputtext disabled" autocomplete="off" type="text" value="" disabled><span class="overlay"></span></div>'.

            '</div>'.

        '</div>';
	}
	public function table_code_bus($data=array())
	{
		return '<div class="table-code-wrap" data-plugin="tableCode">'.

			'<div class="row no-gutters table-code-input"><tbody><tr>'.

				'<div class="col-auto td-input"><input id="code-route" class="inputtext disabled" autocomplete="off" type="text" value="'.( !empty($data['frist_code'])? $data['frist_code']:'').'" disabled><span class="overlay">'.( !empty($data['frist_code'])? $data['frist_code']:'').'</span></div>'.
				'<div class="col-auto td-x">-</div>'.
				'<div class="col-auto td-input"><input id="code" class="inputtext" autocomplete="off" type="text" name="code" value="'.( !empty($data['code'])? $data['code']:'').'" maxlength="10"><span class="overlay">'.( !empty($data['code'])? $data['code']:'').'</span></div>'.
				'<div class="col-auto td-x">-</div>'.
				'<div class="col-auto td-input"><input id="code-air" class="inputtext disabled" autocomplete="off" type="text" value="'.( !empty($data['last_code'])? $data['last_code']:'').'" disabled><span class="overlay">'.( !empty($data['last_code'])? $data['last_code']:'').'</span></div>'.

            '</div>'.

        '</div>';
	}

	public function choosefile_file($options=array())
	{

		$Op = array_merge( array(
			'accept'=> '',
			'name' => 'file1',
			'label' => 'เลือกไฟล์',
			'note' => '(ขนาดสูงสุด 100 MB)',
			'title' => 'เลือกไฟล์จากคอมพิวเตอร์ของคุณ',
		), $options );
		 return '<div class="choosefile-wrap" data-plugin="chooseFile">'.

		 	( !empty($Op['title']) ? '<div class="mbs fwb">'.$Op['title'].'</div>' : '' ).

		 	'<div class="row no-gutters">'.
		 		'<div class="col-auto">'.
		            '<button type="button" class="btn btn-choosefile">'.
		                '<input type="file" name="'.$Op['name'].'" accept="'.$Op['accept'].'" />'.
		                '<span>'.$Op['label'].'</span>'.
		            '</button>'.

            	'</div>'.
		 		'<div class="col"><div class="choosefile-content">'.
                	'<span class="name" data-name="ยังไม่ได้เลือกไฟล์">ยังไม่ได้เลือกไฟล์</span>'.
                	'<span class="remove mls btn" data-action="remove"><i class="icon-remove"></i></span>'.
            	'</div></div>'.
            '</div>'.

            ( !empty($Op['note']) ? '<div class="mts fcg">'.$Op['note'].'</div>' : '' ).
        '</div>';
	}

	public function table_document_tr($data)
	{

		return '<tr>'.
            '<td class="td-label">'.
                '<div class="i-s2 '.$data['type'].'"></div>'.
            '</td>'.
            '<td class="td-text">'.
                '<fieldset id="'.$data['name'].'_fieldset" class="control-group">'.
                    $this->choosefile_file( $data ).
                    '<div class="notification"></div>'.
                '</fieldset>'.
            '</td>'.
        '</tr>';
	}


	public function table_document($options=array())
	{
		$tr = '';
		foreach ($options as $key => $value) {
			$tr .= $this->table_document_tr($value);
		}

		return '<div class="table-document-wrap"><table class="table-document"><tbody>'.$tr.'</tbody></table></div>';
	}


	public function banner($value='')
	{
		return '<div class="uiCoverImageContainer has-empty preview-image" data-width="260" data-height="260" style="width:260px;height:260px">'.
		    
		    '<div class="uiCoverImage_empty"><i class="icon-image"></i></div>'.
		    '<div class="uiCoverImage_image" role="preview"></div>'.
		    // '<div class="uiCoverImage_loader"><div class="progress-bar mini"><span class="blue"></span></div></div>'.
		    '<div class="uiCoverImage_action">'.
		        '<a data-action="change" onclick="PreviewImage.trigger(this)"><i class="icon-camera"></i></a>'.
		        '<a data-action="remove" onclick="PreviewImage.remove(this)"><i class="icon-remove"></i></a>'.
		    '</div>'.
		    
		    '<div class="uiCoverImage_overlay"><input role="button" type="file" accept="image/jpeg,image/png" name="file_image" onchange="PreviewImage.change(this)"></div>'.
		    '<div class="uiCoverImage_loaderspin"><div class="loader-spin-wrap"><div class="loader-spin"></div></div></div>'.

		'</div>';
	}
}