<?php
/**
 * Created by PhpStorm.
 * User: execter
 * Date: 12/9/2015 AD
 * Time: 15:54
 */

namespace App\Lib\Ggseven;


interface FileUploadListenerInterface
{
    public function onFileUploadNotFound();
    public function onMimeTypeMismatch($message = '');
    public function onFileUploadDamage($message = '');
    public function onMaxFileSizeError($message = '');
}