<?php
/**
 * Created by PhpStorm.
 * User: execter
 * Date: 1/29/2016 AD
 * Time: 11:25
 */

namespace App\Lib\Ggseven\Listeners;


interface AssociateListenerInterface
{
    public function onAssociateNotFound($message);
    public function onAssociateUpdateComplete($message);
    public function onAssociateUpdateError($message);
}