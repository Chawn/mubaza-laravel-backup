<?php
/**
 * Created by PhpStorm.
 * User: execter
 * Date: 11/26/2015 AD
 * Time: 09:58
 */

namespace App\Lib\Ggseven\Facades;
use Illuminate\Support\Facades\Facade;

class OrderTrackingFacade extends Facade
{
    protected static function getFacadeAccessor() { return 'order-tracking-service'; }
}