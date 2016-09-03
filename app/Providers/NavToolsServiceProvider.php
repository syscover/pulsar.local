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
		require $this->app->basePath() . '/workbench/syscover/nav-tools/vendor/autoload.php';

		// include helpers file
		require $this->app->basePath() . '/workbench/syscover/nav-tools/src/Syscover/NavTools/Helpers/helpers.php';

		// register config files
		$this->publishes([
			$this->app->basePath() . '/workbench/syscover/nav-tools/src/config/navTools.php' => config_path('navTools.php')
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