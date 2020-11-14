<?php
/**
 * Created by PhpStorm.
 * User: execter
 * Date: 12/9/2015 AD
 * Time: 09:24
 */

namespace App\Lib\Ggseven;

class ImageService
{
    public function __construct ()
    {
    }

    public function upload ($file_upload, $path, $file_name)
    {
        $destination = $path . '/' . $file_name;

        \Storage::makeDirectory($path);

        if ( !$this->startUpload(\File::get($file_upload), $destination) ) {
            return false;
        }

        return true;
    }

    public function startUpload ($source, $destination)
    {
        return \Storage::disk('local')->put($destination, $source);
    }

    public function checkSize ($path, $max_width, $max_height, $min_width = 0, $min_height = 0, $equal = false)
    {
        //  TODO : Intervention Image require edit memory_limit in php.ini for more memory consume
        $img = \Image::make($path);

        $source_width = $img->getWidth();
        $source_height = $img->getHeight();

        if ( $equal ) {
            return ($source_width == $max_width) && ($source_height == $max_height);
        }

        return (($source_width >= $min_width) || ($source_width <= $max_width)) && (($source_height >= $min_height) || ($source_height <= $max_height));
    }

    public function resize ($source, $destination, $width, $height)
    {
//        if(\Storage::exists($destination)) {
//            \Storage::delete($destination);
//        }

        $img = \Image::make(storage_path('app/' . $source));
        $img->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });

        return $img->save(storage_path('app/' . $destination));
    }
}