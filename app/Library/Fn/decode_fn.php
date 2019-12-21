<?php
class Decode_Fn extends Fn
{
	public function DbjsonToObject($array)
	{
    $obj = json_decode($array,0);

      return $obj;
	}


}
