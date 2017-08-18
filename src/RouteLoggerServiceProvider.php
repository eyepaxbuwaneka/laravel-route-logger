<?php

namespace Eyepax\RouteLogger;

use Illuminate\Support\ServiceProvider;

class RouteLoggerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/database');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app['router']->middleware('RouteLoggerServiceProvider', \Eyepax\RouteLogger\RouteLoggerServiceProvider::class);
    }
}