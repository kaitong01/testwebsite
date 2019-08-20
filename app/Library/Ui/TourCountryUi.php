<?php

class TourCountryUi extends Ui
{
	function __construct() {
        parent::__construct();
    }

    // private $_obj = 'category';
    // public $keys = array();



    public function init( $data, $ops=array() )
    {

    	$tr = '';
    	$keys = $this->keys();

    	$seq = ($ops['page'] * $ops['limit']) - $ops['limit'];


    	// title
    	if( $ops['page']==1 ){
	    	$ths = '';
	    	foreach ($keys as $key => $value) {

	    		$label = isset($value['label']) ?$value['label']: '';
					$ico = isset($value['icon']) ? '<i class="mr-1 icon-'.$value['icon'].'"></i>':'';
	    		$cls = isset($value['cls']) ? ' class="'.$value['cls'].'"':'';
				$ths .= '<th'.$cls.'>'.$ico.'<span>'.$label.'</span></th>';
				//  data-col="'.$key.'"
			}
			$tr .= '<tr role="table__fixed">'.$ths.'</tr>';
		}



		foreach ($data as $key => $item) {
			$seq ++;
			$item = json_decode( json_encode($item), 1);

			$tds = '';
			foreach ($keys as $label) {

				$type = isset($label['type'])? $label['type']: 'text';
				$val = '';
				if( $type=='text' ){

					$val = !empty($item[$label['id']])? $item[$label['id']]: '';

					if( $label['id']=='name' ){

						$val = $this->_groupname( $item );
					}

				} else if($type=='index'){
					$val = $seq;

				} else if($type=='date'){
					 if( !empty($item[$label['id']]) ){
			            $val = date('Y/m/d H:s', strtotime($item[$label['id']]));
			        }

			        $val = '<span ref="updated_str">'.$val.'</span>';

				} else if($type=='move'){
					$val = '<div class="handle"></div>';

				} else if($type=='status'){
					$val = $this->_status( $item );
				} else if($type=='action'){
					$val = $this->_action( $item );;

				}


	    		$cls = isset($label['cls']) ? ' class="'.$label['cls'].'"':'';
				$tds .= '<td'.$cls.'>'.$val.'</td>';
			}

			$tr .= '<tr blog-category-id="'.$item['id'].'">'.$tds.'</tr>';
		}

    	return $tr;
    }



}
