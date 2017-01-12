<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Syscover\HotelManager\Services\HotelManagerService;

class HotelManagerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // load autoload from package composer.json
        require $this->app->basePath() . '/workbench/syscover/laravel-hotel-manager/vendor/autoload.php';

        // include route.php file
        if (!$this->app->routesAreCached())
            require $this->app->basePath() . '/workbench/syscover/laravel-hotel-manager/src/routes.php';

        // register translations
        $this->loadTranslationsFrom($this->app->basePath() . '/workbench/syscover/laravel-hotel-manager/src/lang', 'hotelManager');

        // register config files
        $this->publishes([
            $this->app->basePath() . '/workbench/syscover/laravel-hotel-manager/src/config/hotelManager.php' => config_path('hotelManager.php'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('HotelManager', function($app)
        {
            return new HotelManagerService($app);
        });
    }
}