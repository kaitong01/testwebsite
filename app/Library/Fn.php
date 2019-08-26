<?php

namespace App\Library;

class Fn
{
    private $_q = array();
    public function q( $query ){

        if(array_key_exists($query, $this->_q)==false){
            require_once "Fn/{$query}_fn.php";
            $_fn = $query . '_Fn';
            $this->_q[$query] = new $_fn;
        }

        return $this->_q[$query];
    }


    public static function stringify($data)
    {
        if( is_string($data) ){
            $data = array( 'data' => $data );
        }

        return json_encode($data);
    }
    public function _stringify($data)
    {
        if( is_string($data) ){
            $data = array( 'data' => $data );
        }

        return htmlentities(json_encode($data));
    }

    public static function formError($err) {
        $err = explode(',', rtrim($err, ','));

        $error = array();
        foreach ($err as $k) {
            $str = explode('=>', $k);
            $error[$str[0]] = $str[1];
        }

        return $error;
    }


    public static function periodDate($start, $end)
    {
        $months = array(1=>"ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
        $startTime = strtotime($start);
        $endTime = strtotime($end);

        if( $startTime==$endTime ){
            $text = date('j', $startTime);
        }
        else{
            $text = date('j', $startTime).'-'.date('j', $endTime);
        }

        $text .= ' '. $months[ date('n', $endTime) ];
        $text .= ' '. date('Y', $endTime);

        return $text;
    }
}
