<?php 

namespace Yaro\TableBuilder;

use Yaro\TableBuilder\Commands\PrepareArtisanCommand;
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
        
        $this->doCommandsRegister();
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
	} // end register
	
	private function doCommandsRegister()
    {
        $this->app->bind('tb::command.prepare', function($app) {
            return new PrepareArtisanCommand();
        });
        $this->commands(array(
            'tb::command.prepare'
        ));
    } // end doCommandsRegister

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