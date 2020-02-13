<?php

namespace Tapp\Ezeep;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class EzeepServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->registerRoutes();

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('ezeep.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'ezeep');

        // Register the main class to use with the facade
        $this->app->singleton('ezeep', function ($app) {
            return new EzeepManager($app);
        });
    }


    private function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/routes.php');
        });
    }

    /**
     * Get the Telescope route group configuration array.
     *
     * @return array
     */
    private function routeConfiguration()
    {
        return [
            'namespace' => 'Tapp\Ezeep\Http\Controllers',
            'prefix' => 'laravel-ezeep',
        ];
    }
}
