<?php

namespace App\Library;

class Business
{
	
    public static $_data = array();
    public function set($data)
    {
        Business::$_data = json_decode( json_encode($data) );
    }
    public function get($key=null)
    {
        if( $key!==null ){
            return Business::$_data->{$key};
        }
        else{
            return Business::$_data;
        }
    }
}
