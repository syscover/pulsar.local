<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class VinipadServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		// load autoload from package composer.json
		require $this->app->basePath() . '/workbench/syscover/vinipad/vendor/autoload.php';

		// include route.php file
		if (!$this->app->routesAreCached())
			require $this->app->basePath() . '/workbench/syscover/vinipad/src/routes.php';

		// register views
		$this->loadViewsFrom($this->app->basePath() . '/workbench/syscover/vinipad/src/views', 'vinipad');

        // register translations
        $this->loadTranslationsFrom($this->app->basePath() . '/workbench/syscover/vinipad/src/lang', 'vinipad');

		// register config files
		$this->publishes([
			$this->app->basePath() . '/workbench/syscover/vinipad/src/config/vinipad.php' 			    => config_path('vinipad.php')
		]);

        // register migrations
        $this->publishes([
            $this->app->basePath() . '/workbench/syscover/vinipad/src/database/migrations/' 			=> base_path('/database/migrations'),
			$this->app->basePath() . '/workbench/syscover/vinipad/src/database/migrations/updates/' 	=> base_path('/database/migrations/updates')
        ], 'migrations');

        // register seeds
        $this->publishes([
            $this->app->basePath() . '/workbench/syscover/vinipad/src/database/seeds/' 				    => base_path('/database/seeds')
        ], 'seeds');
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