<?php

namespace Yaro\TableBuilder;

use Yaro\TableBuilder\Commands\PrepareArtisanCommand;
use Yaro\TableBuilder\Commands\CreateAdminUserArtisanCommand;
use Yaro\TableBuilder\Commands\CreateSuperUserArtisanCommand;
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

        include __DIR__.'/../../helpers.php';
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

        $this->doCommandsRegister();
    } // end register

    private function doCommandsRegister()
    {
        $this->app['command.tablebuilder.prepare'] = $this->app->share(
            function ($app) {
                return new PrepareArtisanCommand();
            }
        );
        $this->app['command.tablebuilder.create_admin_user'] = $this->app->share(
            function ($app) {
                return new CreateAdminUserArtisanCommand();
            }
        );
        $this->app['command.tablebuilder.create_superuser'] = $this->app->share(
            function ($app) {
                return new CreateSuperUserArtisanCommand();
            }
        );

        $this->commands(array(
            'command.tablebuilder.prepare',
            'command.tablebuilder.create_admin_user',
            'command.tablebuilder.create_superuser',
        ));
    } // end doCommandsRegister

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array(
            'command.tablebuilder.prepare',
            'command.tablebuilder.create_admin_user'
        );
    }

}