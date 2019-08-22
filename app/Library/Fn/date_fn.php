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

}
