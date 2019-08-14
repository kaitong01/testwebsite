<?php

class Listbox_Fn extends Fn
{

	public function ul_anchor($data, $options=array(), $item_options=array()) {

		$options = array_merge( array(
			'addClass' => 'ui-lists'
		), $options);

		$cls = !empty($options['addClass']) ? ' class="'.$options['addClass'].'"':'';

		$li = '';
		foreach ($data as $key => $value) {
			$li .= $this->li_anchor( $value, $item_options );
		}

		return '<ul'.$cls.'">'.$li.'</ul>';
	}

	public function li_anchor($data, $options=array() ){

		$options = array_merge(array(
			'icon' => '',
			'addClass' => 'ui-item',
			'size' => ''
		), $options);

		$anchorCls = '';
		// is_array('ui-bucketed',explode(' ', $options['addClass'])) || 
		// 
		if( !empty($options['size']) ){
			$anchorCls = ' anchor'.$options['size'];
		}

		$cls = !empty($options['addClass']) ? ' class="'.$options['addClass'].'"':'';

		$li = '<li'.$cls.'><div class="anchor'.$anchorCls.' clearfix">'.
	        
	        '<div class="avatar lfloat no-avatar mrm"><div class="initials"><i class="icon-user"></i></div></div>'.
	        
	        '<div class="content"><div class="spacer"></div><div class="massages">'.

	            (!empty($data['text'])?'<div class="text">'.$data['text'].'</div>':'').
	            (!empty($data['subtext'])?'<div class="subtext">'.$data['subtext'].'</div>':'').
	            (!empty($data['category'])?'<div class="category">'.$data['category'].'</div>':'').
	            (!empty($data['meta'])?'<div class="meta">'.$data['meta'].'</div>':'').
	            
	        '</div></div>'.
	    '</div></li>';

	    return $li;
	}

	public function setFilter($filters=array(), $options=array())
	{
		$li = '';
		foreach ($filters as $index => $val) { 

			$type = isset($val['type'])? $val['type']: '';
			$cls = isset($val['cls'])? $val['cls']: '';

			if( $type=='refreshList' || $type=='refresh' ){

				$li .= '<li class="filter-item filter-item-auto filter-item-refresh"><button type="button" class="bbtn btn-light" id="refreshList" title="Refresh List" data-action="refresh"><i class="icon-refresh"></i></button></li>';

			} elseif( $type=='clear' ){
				$li .= '<li class="filter-item filter-item-auto filter-item-clearall hidden_elem"><button type="button" class="btn" id="clearall" data-action="clearall">Clear</button></li>';
			} elseif( $type=='submit' ){

				$li .= '<li class="filter-item filter-item-auto filter-item-submit"><button type="button" class="btn btn-primary" id="submit" data-action="submit">ค้นหา</button></li>';
			} elseif( $type=='search' ){
				$li .= '<li class="filter-item">
					<label for="search-query" class="label">ค้นหา</label>
					<form class="form-search" data-action="formsearch">
					<input class="inputtext search-input" type="text" id="search-query" placeholder="" name="q" autocomplete="off">
					<span class="search-icon"><button type="submit" class="icon-search nav-search" tabindex="-1"></button></span>
				</form></li>';
			
			} else if($type=='select' && isset($val['multiple'])  ){

				$item = ''; 
				foreach ($val['items'] as $key => $value) {

					$cls = 'dropdown-item';
					if( isset($val['active']) ){
						if( $value['id']==$val['active']){
							$cls .= ' active';
						}
					}

					$count = '';
					if( isset($value['count']) ){
						$count = "({$value['count']})";
					}

					$item .= '<div class="'.$cls.'"><label class="checkbox"><input type="checkbox" value="'.$value['id'].'" /><span>'.$value['name'].$count.'</span></label></div>';
				}


				$li .= '<li class="filter-item dropdown">'.
					// '<div for="'.$val['id'].'" class="label"></div>'.
					'<input class="inputtext dropdown-toggle" type="text" data-toggle="dropdown" placeholder="" autocomplete="off">'.
					// '<button class="btn dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.$val['label'].'</button>'.
					'<div class="dropdown-menu">'.$item.'</div>'.
				'</li>';

			} else if($type=='select'){

				$item = ''; 
				foreach ($val['items'] as $key => $value) {

					$active = '';
					if( isset($val['active']) ){
						if( $value['id']==$val['active']){
							$active = ' selected';
						}
					}

					$count = '';
					if( isset($value['count']) ){
						$count = "({$value['count']})";
					}

					$item .= '<option'.$active.' value="'.$value['id'].'">'.$value['name'].$count.'</option>';
				}

				$onchange = isset($val['onchange']) ? ' onchange="'.$val['onchange'].'"': '';

				$cls = !empty($cls) ? " {$cls}":'';
				$li .= '<li class="filter-item'.$cls.'">
					<label for="'.$val['id'].'" class="label">'.$val['label'].'</label>
					<select id="'.$val['id'].'" name="'.$val['id'].'" class="inputtext" data-action="change"'.$onchange.'>
						<option value="">-- ทั้งหมด -- '.(isset($val['count'])? "({$val['count']})":'').'</option>'.
						$item.
					'</select>
				</li>';
			} else if( $type=='multichecked' ){

				$item = '';
				foreach ($val['items'] as $key => $value) {
					if( isset($value['disabled']) ) continue;

					$name = isset($value['desc']) ? $value['desc']: $value['name']; 
					$count = isset($value['count'])? '<span class="countVal">(<span class="total">'.number_format($value['count']).'</span>)</span>':'';
					
					$checked = '';
					if( isset($val['value']) ){

						if( is_array($val['value']) ){
							$checked = in_array($value['id'], $val['value'])? ' checked':'';
						}
						else{
							$checked = $value['id']==$val['value']? ' checked':'';
						}
						
					}

					$item .= '<li><label class="checkbox mrs"><input type="checkbox" name="'.$val['id'].'" value="'.$value['id'].'"'.$checked.' data-action="multichecked"><span class="fwb">'.$name.$count.'</span></label></li>';
				}

				$li .= '<li class="filter-item multichecked'.$cls.'" data-type="multichecked">'.
					( !empty($val['label']) 
						? '<label class="label">'.$val['label'].'</label>'
						: ''
					).
					'<ul class="multichecked-list">'.$item.'</ul>'.
				'</li>';
			} else if( $type=='caleran' ){
				$id = isset($val['id']) ? $val['id']: '';

				$li .= '<li class="filter-item daterange">'.
					( !empty($val['label']) 
						? '<label for="'.$val['id'].'" class="label">'.$val['label'].'</label>'
						: ''
					).
					'<input type="text" id="'.$val['id'].'" name="'.$val['id'].'" class="inputtext daterange-input" data-action="daterange" />'.
					'<button class="daterange-clear" type="button" data-action="cleardate"><i class="icon-remove"></i></button>'.
				'</li>';
			}
		}

		return '<ul class="filter-list clearfix">'.$li.'</ul>';
	}


}