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


    public static function getGalleryCover($data=[])
    {
        if( !empty($data) ){
            $data = json_decode($data);
            return !empty($data->{0})? $data->{0}: null;
        }
        else{
            return null;
        }
    }
    public static function getGalleryCoverElem($data=[])
    {
        if( !empty($data) ){
            $data = json_decode($data);
            $img = !empty($data[0])? $data[0]: null;

            if( !empty($img) ){
                if( isset($img->path) ){
                    echo '<img src="'.asset("storage/{$img->path}").'" alt="'.$img->name.'" >';
                }
                else if( isset($img->url) ){
                    echo '<img src="'.$img->url.'" alt="'.$img->name.'" >';
                }
            }
        }
    }


    public static function getPeriodConclusion($start, $end, $delimiter=',')
    {
        // dd( $start );
        $startDate = explode($delimiter, $start);
        $endDate = explode($delimiter, $end);

        // $startDateEnd = strtotime( end($startDate) );
        // $endDateEnd = strtotime( end($endDate) );
        $startDateTime = strtotime( $startDate[0] );
        $endDateTime = strtotime( end($startDate) );

        $months = array(1=>"ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");

        if( $startDateTime==$endDateTime ){

            return date('j', $startDateTime). ' '. $months[date('n', $endDateTime)] . ' '. date('Y', $startDateTime);

        } elseif( date('m', $startDateTime) == date('m', $endDateTime) ){

            return date('j', $startDateTime) .' - '. date('j', $endDateTime). ' '. $months[date('n', $endDateTime)] . ' '. date('Y', $startDateTime);

        } else {
            return date('j', $startDateTime).' '.$months[date('n', $startDateTime)] .' - '. date('j', $endDateTime). ' '. $months[date('n', $endDateTime)] . ' '. date('Y', $endDateTime);
        }

        // $startEnd = ;
        return self::periodDate( $startDate[0], end($startDate) );
        // dd( $startEnd );
    }

    public static function getPeriodCount($start, $delimiter=',')
    {
        return count(explode($delimiter, $start));
    }

}
