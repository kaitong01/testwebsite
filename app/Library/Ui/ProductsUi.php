<?php

class ProductsUi extends Ui
{
	function __construct() {
        parent::__construct();
    }

    // private $_obj = 'category';
    // public $keys = array();

    public function keys()
    {
    	$key = array();

    	$key[] = array('label'=>'#', 'cls'=>'td-index', 'type'=>'index');



			$key[] = array('id'=>'status', 'label'=>'สถานะ', 'cls'=>'td-status', 'type'=>'status');
			$key[] = array('id'=>'name', 'label'=>'แพ็คเกจทัวร์', 'cls'=>'td-name');
    	    $key[] = array('id'=>'updated_at', 'label'=>'แก้ไขล่าสุด', 'cls'=>'td-date td-light', 'type'=>'date');

			// $key[] = array('id'=>'wholesales', 'label'=>'โฮลเซลล์', 'cls'=>'');
			// $key[] = array('id'=>'action', 'cls'=>'td-action', 'type'=>'action');

    	return $key;
    }

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
					}elseif($label['id']=='wholesales')
					{
							$val = $this->_wholesales( $item );
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


		public function _wholesales($data)
    {

    	return '<div ><span style="font-size:16px;font-weight:bold">'.$data['wholesales'].'</span></div>.';
    }


    public function _groupname($data)
    {

        $picture = !empty($data['image'])
            ? '<img src="'. asset("storage/{$data['image']}").'" alt="" />'
            : '';
        //Storage::disk('locol')->url($data['image'])

    	return '<div class="media">'.
			'<div class="pic-wrap mr-2"><div class="pic">'.$picture.'</div></div>'.
			'<div class="media-body">'.
                '<span class="box-code">'.$data['code'].'</span>'.
                '<div><a href="'.asset('products/'.$data['id']).'"><strong ref="name">'.$data['name'].'</strong></a></div>'.
                //  data-plugin="lightbox"
			'</div>'.
		'</div>';
    }

    public function _status($data)
    {
    	$val = '';

    	if( !empty($data['status_arr']) ){
    		$val = '<div class="ui-status" style="background-color:'.$data['status_arr']['color'].';color:#fff" data-ref="status_arr" data-type="status">'.$data['status_arr']['name'].'</div>';

    	}
    	else{
	    	switch ($data['status']) {
	    		case 1:
	    			$val = '<div class="ui-status primary" data-ref="status_arr" data-type="status">ใช้งาน</div>';
	    			break;

	    		case 2:
	    			$val = '<div class="ui-status danger" data-ref="status_arr" data-type="status">ระงับ</div>';
	    			break;

						case 0:
		    			$val = '<div class="ui-status secondary" data-ref="status_arr" data-type="status">แบบร่าง</div>';
		    			break;
	    	}
    	}

    	return $val;
    }


    public function _action($data)
    {
    	$val = '<a href="'.asset('blogs/add/'.$data['id']).'/edit" data-plugin="lightbox" class="btn btn-sm btn-primary" title="แก้ไข"><i class="fa fa-pencil"></i></a>';
		$val .= '<a href="'.asset('blogs/add/'.$data['id'].'/delete').'" data-plugin="lightbox" class="btn btn-sm btn-danger ml-2" title="ลบ"><i class="fa fa-remove"></i></a>';

		return $val;
    }
}
