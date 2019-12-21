<?php
class Date_Fn extends Fn
{
	public function convertDate_th($data)
	{
      $d = substr($data,0,2);
      $m = substr($data,3,2);
      $y = substr($data,6,4);

       $date = $y.'-'.$m.'-'.$d;
      return $date;
	}

	public function convertDateTo_th($data)
	{
      $d = substr($data,8,2);
      $m = substr($data,5,2);
      $y = substr($data,0,4);

       $date = $d.'/'.$m.'/'.$y;
      return $date;
	}

	public function findBetween($date)
	{
		$date=date_create($date);
		$today_w = date_format($date,"w");
		$today_date = date_format($date,"Y-m-d");
		switch ($today_w) {
				case 0:
    			$start_date = date('Y-m-d',strtotime($today_date . "-6 days"));
				$end_date = $today_date;
        break;
				case 1:
				$start_date = $today_date;
				$end_date =date('Y-m-d',strtotime($today_date . "+6 days"));
        break;
				case 2:
				$start_date = date('Y-m-d',strtotime($today_date . "-1 days"));
				$end_date = date('Y-m-d',strtotime($today_date . "+5 days"));
        break;
				case 3:
				$start_date = date('Y-m-d',strtotime($today_date . "-2 days"));
				$end_date = date('Y-m-d',strtotime($today_date . "+4 days"));
        break;
				case 4:
				$start_date = date('Y-m-d',strtotime($today_date . "-3 days"));
				$end_date = date('Y-m-d',strtotime($today_date . "+3 days"));
        break;
				case 5:
				$start_date = date('Y-m-d',strtotime($today_date . "-4 days"));
				$end_date = date('Y-m-d',strtotime($today_date . "+2 days"));
        break;
				case 6:
				$start_date = date('Y-m-d',strtotime($today_date . "-5 days"));
				$end_date = date('Y-m-d',strtotime($today_date . "+1 days"));
        break;

}
			$between = [$start_date,$end_date];
      return $between;
	}


}
