<?php namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Syscover\Pulsar\Libraries\CustomValidator;

class AdministrationServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		// load autoload from package composer.json
		require $this->app->basePath() . '/workbench/syscover/administration/vendor/autoload.php';

		// include route.php file
		if (!$this->app->routesAreCached())
			require $this->app->basePath() . '/workbench/syscover/administration/src/routes.php';

		// register views
		$this->loadViewsFrom($this->app->basePath() . '/workbench/syscover/administration/src/views', 'administration');

		// register translations
		$this->loadTranslationsFrom($this->app->basePath() . '/workbench/syscover/administration/src/lang', 'administration');

		// register config files
		$this->publishes([
            $this->app->basePath() . '/workbench/syscover/pulsar/src/config/cron.php' 				=> config_path('cron.php')
		]);

        // register migrations and updates
        $this->publishes([
            $this->app->basePath() . '/workbench/syscover/pulsar/src/database/migrations/' 			=> base_path('/database/migrations'),
			$this->app->basePath() . '/workbench/syscover/pulsar/src/database/migrations/updates/' 	=> base_path('/database/migrations/updates')
        ], 'migrations');

        // register seeds
        $this->publishes([
            $this->app->basePath() . '/workbench/syscover/administration/src/database/seeds/' 		=> base_path('/database/seeds')
        ], 'seeds');

		// register factories
		$this->publishes([
			$this->app->basePath() . '/workbench/syscover/administration/src/database/factories/' 	=> base_path('/database/factories')
		], 'factories');

		// register tests
		$this->publishes([
			$this->app->basePath() . '/workbench/syscover/administration/src/tests/'      	        => base_path('/tests')
		], 'tests');

		// custom validator rules
		Validator::extend('digit', function($attribute, $value, $parameters, $validator) {
			return (strlen($value) == $parameters[0])? true : false;
		});

		Validator::extend('cronExpression', function($attribute, $value, $parameters, $validator) {
			try
			{
				\Cron\CronExpression::factory($value);
				return true;
			}
			catch (\InvalidArgumentException $e)
			{
				return false;
			}
		});
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