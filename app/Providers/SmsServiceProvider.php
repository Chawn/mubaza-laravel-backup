<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SmsServiceProvider extends ServiceProvider
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
        \App::bind('smssender', function()
        {
            return new \App\Providers\Sms\Sms;
        });
    }
}
