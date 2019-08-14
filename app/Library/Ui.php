<?php

namespace App\Library;

use App\Library\Fn;
// require_once 'Fn.php';

class Ui {

    function __construct() { 
        $this->fn = new Fn();
    }

    private $_query = array();
    public function frame($q='default')
    {


    	$path = "Ui/{$q}.php";
        // echo $path; die;
    	// if( file_exists($path) ){

	    	if(array_key_exists($q, $this->_query)==false){
	            require_once $path;
	            $clsName = ucfirst($q) . '_Ui';
	            $this->_query[$q] = new $clsName;
	        }


	        return $this->_query[$q];
        // }

    }

    private $_dataFun= array();
    public function req($filename='')
    {
        $filename = ucfirst($filename);
        $path =  "Ui/{$filename}_Ui.php";

        // if( file_exists( $path ) ){

            require_once $path;

            if(array_key_exists($filename, $this->_dataFun)==false){
                $clsName = $filename . '_Ui';
                $this->_dataFun[$filename] = new $clsName;
            }
        // }


        return isset($this->_dataFun[$filename]) ?$this->_dataFun[$filename]: $this;
    }
}