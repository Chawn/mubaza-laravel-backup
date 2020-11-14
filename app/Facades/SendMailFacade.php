<?php
/**
 * Created by PhpStorm.
 * User: execter
 * Date: 11/26/2015 AD
 * Time: 09:58
 */

namespace App\Facades;
use Illuminate\Support\Facades\Facade;

class SendMailFacade extends Facade
{
    protected static function getFacadeAccessor() { return 'sendmail'; }
}