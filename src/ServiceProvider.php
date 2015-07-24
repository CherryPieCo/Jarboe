<?php

namespace Yaro\Jarboe;

use Yaro\Jarboe\Commands\PrepareArtisanCommand;
use Yaro\Jarboe\Commands\CreateAdminUserArtisanCommand;
use Yaro\Jarboe\Commands\CreateSuperUserArtisanCommand;
use Yaro\Jarboe\Commands\CreateDefinitionArtisanCommand;
use Yaro\Jarboe\Commands\ComponentCommand;


class ServiceProvider extends \Illuminate\Support\ServiceProvider 
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;
    
    /**
     * Configurations list.
     * 
     * @var array
     */
    private $configs = [
        'admin', 
        'components', 
        'files',
        'images', 
        'informer', 
        'login', 
        'translate', 
        'users', 
    ];

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerConfigurations();
        $this->registerAliases();
    } // end boot
    
    private function registerAliases()
    {
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        
        $loader->alias('Jarboe', 'Yaro\Jarboe\Facades\Jarboe');
        $loader->alias('Settings', 'Yaro\Jarboe\Helpers\Settings');
        
        $loader->alias('Activation', 'Cartalyst\Sentinel\Laravel\Facades\Activation');
        $loader->alias('Reminder', 'Cartalyst\Sentinel\Laravel\Facades\Reminder');
        $loader->alias('Sentinel', 'Cartalyst\Sentinel\Laravel\Facades\Sentinel');
        
        $loader->alias('Image', 'Intervention\Image\Facades\Image');
    } // end registerAliases
    
    private function registerConfigurations()
    {
        $this->mergeConfigurations();
        
        $this->publishes([
            __DIR__ .'/../public' => public_path('packages/yaro/jarboe'),
        ], 'public');
        
        $this->app['view']->addNamespace('admin', __DIR__ . '/../resources/views');
        $this->app['translator']->addNamespace('jarboe', __DIR__ . '/../resources/lang'); 
    } // end registerConfigurations
    
    private function onSingleConfigRegister($ident)
    {
        $this->publishes([
             __DIR__ .'/../config/'. $ident .'.php' => config_path('jarboe/'. $ident .'.php'),
        ]);
    } // end onSingleConfigRegister

    private function mergeConfigurations()
    {
        foreach ($this->configs as $config) {
            if ($config == 'components') {
                continue;
            }
            $this->mergeConfigFrom(
                __DIR__ .'/../config/'. $config .'.php', 'jarboe.'. $config
            );
        }
    } // end mergeConfigurations
    
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigurations();
        
        $this->registerServiceProviders();
        $this->registerComponentsServiceProviders();
        
        $this->app['jarboe'] = $this->app->share(function($app) {
            return new Jarboe();
        });

        $this->doCommandsRegister();
    } // end register
    
    private function registerServiceProviders()
    {
        $this->app->register('Yaro\Cropp\ServiceProvider');
        $this->app->register('Baum\Providers\BaumServiceProvider');
        $this->app->register('Cartalyst\Sentinel\Laravel\SentinelServiceProvider');
        $this->app->register('Radic\BladeExtensions\BladeExtensionsServiceProvider');
    } // end registerServiceProviders
    
    private function registerComponentsServiceProviders()
    {
        foreach (config('jarboe.components', []) as $component) { 
            $this->app->register('Jarboe\Component\\'. $component .'\ServiceProvider');
        }
    } // end registerComponentsServiceProviders

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
        $this->app['command.jarboe.component'] = $this->app->share(
            function ($app) {
                return new ComponentCommand();
            }
        );

        $this->commands(array(
            'command.jarboe.component',
            
            
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
            //
        );
    }

}