<?php

namespace Yaro\Jarboe;

use Illuminate\Support\ServiceProvider;
use Yaro\Jarboe\Commands\PrepareArtisanCommand;
use Yaro\Jarboe\Commands\CreateAdminUserArtisanCommand;
use Yaro\Jarboe\Commands\CreateSuperUserArtisanCommand;
use Yaro\Jarboe\Commands\CreateDefinitionArtisanCommand;


class JarboeServiceProvider extends ServiceProvider {

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
        $this->package('yaro/jarboe');

        include __DIR__.'/../../helpers.php';
        include __DIR__.'/../../filters.php';
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
        $this->app['jarboe'] = $this->app->share(function($app) {
            return new Jarboe();
        });

        $this->doCommandsRegister();
    } // end register

    private function doCommandsRegister()
    {
        $this->app['command.jarboe.prepare'] = $this->app->share(
            function ($app) {
                return new PrepareArtisanCommand();
            }
        );
        $this->app['command.jarboe.create_admin_user'] = $this->app->share(
            function ($app) {
                return new CreateAdminUserArtisanCommand();
            }
        );
        $this->app['command.jarboe.create_superuser'] = $this->app->share(
            function ($app) {
                return new CreateSuperUserArtisanCommand();
            }
        );
        $this->app['command.jarboe.create_definition'] = $this->app->share(
            function ($app) {
                return new CreateDefinitionArtisanCommand();
            }
        );
        

        $this->commands(array(
            'command.jarboe.prepare',
            'command.jarboe.create_admin_user',
            'command.jarboe.create_superuser',
            'command.jarboe.create_definition',
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
            'command.jarboe.prepare',
            'command.jarboe.create_admin_user'
        );
    }

}