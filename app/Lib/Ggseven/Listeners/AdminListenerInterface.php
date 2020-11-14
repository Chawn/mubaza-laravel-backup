<?php
/**
 * Created by PhpStorm.
 * User: execter
 * Date: 1/28/2016 AD
 * Time: 11:02
 */

namespace App\Lib\Ggseven\Listeners;


interface AdminListenerInterface
{
    public function onAdminNotFound ();

    public function onAdminUpdated ();

    public function onAdminUpdateError ();

    public function onAdminCreateComplete ();

    public function onAdminCreateError ();
}