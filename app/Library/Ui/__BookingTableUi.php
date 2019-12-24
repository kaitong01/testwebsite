<?php

class BookingTableUi extends Ui
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
			$key[] = array('id'=>'booking_no', 'label'=>'Booking_no', 'cls'=>'td-date','type'=>'booking_no');
    	$key[] = array('id'=>'created_at', 'label'=>'Created', 'cls'=>'td-date', 'type'=>'date');
			$key[] = array('id'=>'cus_name', 'label'=>'Customer', 'type'=>'text');
			$key[] = array('id'=>'tel', 'label'=>'Tel', 'type'=>'text');
			$key[] = array('id'=>'total', 'label'=>'Total', 'cls'=>'td-date','type'=>'total');
    	// $key[] = array('id'=>'updated_at', 'label'=>'สร้างเมื่อ', 'cls'=>'td-date td-light', 'type'=>'date');
			$key[] = array('id'=>'status', 'label'=>'Status', 'cls'=>'td-name','type'=>'status');
			$key[] = array('id'=>'action', 'label'=>'Detail', 'cls'=>'td-name','type'=>'action');


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

					if( $label['id']=='cus_name' ){
						$val = $this->_groupname( $item );
					}
					if( $label['id']=='tel' ){
						$val = $this->_tel( $item );
					}


				} else if($type=='index'){
					$val = $seq;
				} else if($type=='total'){
					$val = $this->_total( $item );


				} else if($type=='date'){
					 if( !empty($item[$label['id']]) ){
			            $val = date('Y/m/d H:s', strtotime($item[$label['id']]));
			        }

			        $val = '<span ref="updated_str">'.$val.'</span>';

				} else if($type=='booking_no'){
					$val = $this->_booking_no($item);

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


    public function _groupname($data)
    {


    	return '<div class="row">
			<div class="col-6">
			<span>'.$data['booking_cus_fname'].'</span>
			</div>
			<div class="col-6">
			<span>'.$data['booking_cus_lname'].'</span>
			</div>
			</div>';
    }
		public function _booking_no($data)
		{

			$val = '<span>'.$data['booking_no'].'</span>';
			return $val;
		}
		public function _tel($data)
		{

			$val = '<span>'.$data['booking_cus_tel'].'</span>';
			return $val;
		}
		public function _total($data)
		{

			$val = '<span>'.number_format($data['booking_amount'],2).'</span>';
			return $val;
		}
    public function _status($data)
    {
    	$val = '';


	    	switch ($data['status']) {
	    		case 0:
	    			$val = '<div class="dropdown">
							  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							   รอตรวจสอบ
							  </button>
							  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
							    <a class="dropdown-item" href="'.asset('booking/setstatus/'.$data['id'].'/checked').'">ตรวจสอบแล้ว</a>
							  </div>
							</div>';
	    			break;

	    		case 1:
	    			$val = '<button class="btn btn-success " type="button"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							   ตรวจแล้ว
							  </button>';
	    			break;

    	}

    	return $val;
    }


    public function _action($data)
    {
		$val ='<a href="'.asset('booking/detail/'.$data['id']).'" data-plugin="lightbox" class="ml-2" ><img src="https://img.icons8.com/windows/32/000000/info.png"></a>';
		return $val;
    }
}
