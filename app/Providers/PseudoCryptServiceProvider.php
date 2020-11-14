<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class PseudoCryptServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        \App::bind('pseudocrypt', function()
        {
            return new \App\Providers\Lib\PseudoCrypt\PseudoCrypt();
        });
    }
}
