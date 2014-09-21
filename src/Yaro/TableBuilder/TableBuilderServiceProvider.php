<?php 

namespace Yaro\TableBuilder;

use Yaro\TableBuilder\PrepareArtisanCommand;
use Illuminate\Support\ServiceProvider;


class TableBuilderServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('yaro/table-builder');
        
        //include __DIR__.'/../../filters.php';
        include __DIR__.'/../../routes.php';
        
        \View::addNamespace('admin', __DIR__.'/../../views/');
	} // end boot

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['tablebuilder'] = $this->app->share(function($app) {
            return new TableBuilder();
        });
        
        // register artisan command
        $this->app['prepare'] = $this->app->share(function($app) {
            return new PrepareArtisanCommand();
        });
        $this->commands('prepare');
	} // end register

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}