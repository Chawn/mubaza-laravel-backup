<?php
/**
 * Created by PhpStorm.
 * User: execter
 * Date: 12/8/2015 AD
 * Time: 13:19
 */

namespace app\Lib\Ggseven\Providers;

use Illuminate\Support\ServiceProvider;
class OrderServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register ()
    {
        \App::bind('order-service', '\App\Lib\Ggseven\OrderService');
    }
}