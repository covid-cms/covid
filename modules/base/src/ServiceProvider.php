<?php

namespace Covid\Base;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Laravel\Passport\Passport;

class ServiceProvider extends LaravelServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        Passport::routes();
    }
}
