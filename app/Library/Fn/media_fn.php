<?php

class Media_Fn extends Fn {
    
    public function getExtension($filename){
        return strtolower(strrchr($filename, '.'));
    }

    public function download($options=array())
    {
        $options = array_merge( array('w'=>null, 'h'=>null), $options );

        $filename = $options['filename'];
        $original = $options['original'];

        // $ext = $this->fn->q('file')->getExtension($filename);

        $source =  $options['source'];
        $path =  $options['path'];
        $download_file = htmlentities($original);

        if( !file_exists($source) ) $this->error();


        list($original_width, $original_height, $image_type) = getimagesize($source);

        $set_width = isset($_REQUEST['w']) ? $_REQUEST['w']: $options['w'];
        $set_height = isset($_REQUEST['h']) ? $_REQUEST['h']: $options['h'];

        switch ($image_type)
        {
            case 1: $src = imagecreatefromgif($path); break;
            case 2: $src = imagecreatefromjpeg($path);  break;
            case 3: $src = imagecreatefrompng($path); break;
            default: return '';  break;
        }

        if( $set_width && $set_height ){

            if( $original_width > $original_height && $original_width > $set_width  ){
                
                $width = $set_width;
                $height = round( ( $set_width*$original_height ) / $original_width );

                if( $height < $set_height ){
                    $height = $set_height;
                    $width = round( ( $set_height*$original_width ) / $original_height );
                }

            }
            elseif($original_height > $set_height){

                $height = $set_height;
                $width = round( ( $set_height*$original_width ) / $original_height );

                if( $width < $set_width ){
                    $width = $set_width;
                    $height = round( ( $set_width*$original_height ) / $original_width );
                }

            }
            else{
                $width = $set_width;
                $height = $set_height;
            }

            $dst = array(0,0);
            $dst[0] = 0;
            if( $width > $set_width ){
                $dst[0] = ($width - $set_width)/2;
            }

            $dst[1] = 0;
            if( $height > $set_height ){
                $dst[1] = ($height - $set_height)/2;
            }

            // echo 1; die;
        }
        elseif( $set_width && !$set_height ){
            $width = $set_width;
            $height = ($original_height*$set_width)/$original_width;

            $set_height = $height;

            $dst = array(0,0);
        }
        elseif( !$set_width && $set_height ){

            $height = $set_height;
            $width = ($original_width*$set_height)/$original_height;

            $set_width = $width;
            $dst = array(0,0);
        }
        else{
            $width = $original_width;
            $height = $original_height;

            $set_width = $original_width;
            $set_height = $original_height;
            $dst = array(0,0);
        }

        $tmp = imagecreatetruecolor($set_width, $set_height);

        /* Check if this image is PNG or GIF, then set if Transparent*/
        if(($image_type == 1) OR ($image_type==3))
        {
            imagealphablending($tmp, false);
            imagesavealpha($tmp,true);
            $transparent = imagecolorallocatealpha($tmp, 255, 255, 255, 127);
            imagefilledrectangle($tmp, 0, 0, $tn_width, $tn_height, $transparent);
        }
        imagecopyresampled($tmp,$src, 0, 0, $dst[0], $dst[1], $width, $height, $original_width, $original_height);


        /*
         * imageXXX() only has two options, save as a file, or send to the browser.
         * It does not provide you the oppurtunity to manipulate the final GIF/JPG/PNG file stream
         * So I start the output buffering, use imageXXX() to output the data stream to the browser, 
         * get the contents of the stream, and use clean to silently discard the buffered contents.
         */
        ob_start();

        switch ($image_type)
        {
            case 1: imagegif($tmp); break;
            case 2: imagejpeg($tmp, NULL, 100);  break; // best quality
            case 3: imagepng($tmp, NULL, 0); break; // no compression
            default: echo ''; break;
        }

        // $filename = basename($file);
        $file_extension = strtolower(substr(strrchr($filename,"."),1));

        switch( $file_extension ) {
            case "gif": $ctype="image/gif"; break;
            case "png": $ctype="image/png"; break;
            case "jpeg":
            case "jpg": $ctype="image/jpeg"; break;
            default:
        }

        header("Content-Type: {$ctype}");
        header("Content-Disposition: inline; filename=\"{$download_file}\"");

        imagedestroy($tmp);
    }
}

