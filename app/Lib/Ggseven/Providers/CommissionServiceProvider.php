<?php
/**
 * Created by PhpStorm.
 * User: execter
 * Date: 12/8/2015 AD
 * Time: 13:19
 */

namespace app\Lib\Ggseven\Providers;

use Illuminate\Support\ServiceProvider;
class CommissionServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register ()
    {
        \App::bind('commission-service', '\App\Lib\Ggseven\CommissionService');
    }
}