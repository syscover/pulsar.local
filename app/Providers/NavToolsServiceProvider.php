<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class NavToolsServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		// load autoload from package composer.json
		require $this->app->basePath() . '/workbench/syscover/laravel-nav-tools/vendor/autoload.php';

		// register config files
		$this->publishes([
			$this->app->basePath() . '/workbench/syscover/laravel-nav-tools/src/config/navTools.php' => config_path('navTools.php')
		]);
    }

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
        //
	}
}