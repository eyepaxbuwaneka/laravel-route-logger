<?php

    namespace Eyepax\RouteLogger;

    use Illuminate\Support\ServiceProvider;

    /**
     * author: Buwaneka Kalansuriya
     * Class RouteLoggerServiceProvider
     *
     * @package Eyepax\RouteLogger
     */
    class RouteLoggerServiceProvider extends ServiceProvider {
        /**
         * Bootstrap the application services.
         *
         * @return void
         */
        public function boot() {
            $this->loadMigrationsFrom(__DIR__ . '/database');
            $this->publishes([
                __DIR__ . '/config/routelog.php' => config_path('routelog.php'),
            ]);
        }

        /**
         * Register the application services.
         *
         * @return void
         */
        public function register() {
            $this->app['router']->middleware('RouteLoggerServiceProvider', \Eyepax\RouteLogger\RequestResponseLogger::class);
            $this->mergeConfigFrom(
                __DIR__ . '/config/routelog.php', 'routelog'
            );
        }
    }
