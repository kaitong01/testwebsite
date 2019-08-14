<?php

namespace App\Library;

class Fn
{
    public static function stringify($data)
    {
        if( is_string($data) ){
            $data = array( 'data' => $data );
        }

        return json_encode($data);
    }
}
