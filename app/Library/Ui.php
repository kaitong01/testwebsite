<?php

namespace App\Library;

use App\Library\Fn;
// require_once 'Fn.php';

class Ui {

    function __construct() {
        $this->fn = new Fn();
    }

    private $_dataFun= array();
    private $_query = array();
    public function q($name=null)
    {
    	$name = ucfirst($name);
        $path =  "Ui/{$name}.php";

        // if( file_exists( $path ) ){

            require_once $path;

            if(array_key_exists($name, $this->_dataFun)==false){
                $this->_dataFun[$name] = new $name;
            }
        // }

        return isset($this->_dataFun[$name]) ?$this->_dataFun[$name]: $this;
    }

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

    public function item($name=null)
    {
    	$name = ucfirst($name);
        $path =  "Ui/{$name}.php";

        // if( file_exists( $path ) ){

            require_once $path;

            if(array_key_exists($name, $this->_dataFun)==false){
                $this->_dataFun[$name] = new $name;
            }
        // }

        return isset($this->_dataFun[$name]) ?$this->_dataFun[$name]: $this;
    }
}
