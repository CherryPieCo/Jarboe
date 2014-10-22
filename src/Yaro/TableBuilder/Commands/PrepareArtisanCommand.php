<?php

namespace Yaro\TableBuilder\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;


class PrepareArtisanCommand extends Command 
{

    protected $name = 'tb:prepare';

    protected $description = 'TB: prepare package.';

    public function fire()
    {
        if (is_dir(app_path() . '/tb-definitions')) {
            $this->info('Folder /app/tb-definitions is existing. Use it to store your table definitions.');
        } else {
            mkdir(app_path() . '/tb-definitions');
            $this->info('Folder /app/tb-definitions infofully created. Place there your table definitions.');
        }
        
        if ($this->confirm('Create `settings` table with definition? [yes|no]')) {
            \Schema::create('settings', function($table) {
                $table->increments('id')->unsigned();
                $table->char('name', 255)->unique();
                $table->char('value', 255);
                $table->char('description', 255);
            });
            copy(
                __DIR__ . '/../../../tb-definitions/settings.php', 
                app_path() . '/tb-definitions/settings.php'
            );
        }
        
        if ($this->confirm('Create `ip_geo_locations` table? [yes|no]')) {
            \Schema::create('ip_geo_locations', function($table) {
                $table->increments('id')->unsigned();
                $table->char('ip', 32)->unique();
                $table->char('town', 60);
                $table->decimal('longitude', 10, 7);
                $table->decimal('latitude', 10, 7);
            });
        }

        if ($this->confirm('Replace filters.php? [yes|no]')) {
            $res = unlink(app_path() . '/filters.php');
            if ($res) {
                $this->info('infofully unlinked old app/filters.php');
                $res = copy(
                    __DIR__ . '/../../../misc/filters.php', 
                    app_path() . '/filters.php'
                );
                if ($res) {
                    $this->info('infofully copied new filters.php');
                } else {
                    $this->error('Unable to copy new filters.php. Copy it manually.');
                }
            } else {
                $this->error('Unable to unlink app/filters.php');
            }
        }

        
        if ($this->confirm('Prepare Sentry package? [yes|no]')) {
            $this->doPrepareSentry();
        }
        
        if ($this->confirm('Prepare Intervention package? [yes|no]')) {
            $this->doPrepareIntervention();
        }
        
        $this->doPrepareMisc();
    } // end fire
    
    private function doPrepareMisc()
    {
        $this->info('Add following in app/config/app.php');
        $this->comment(
            "providers:\n
            'Radic\BladeExtensions\BladeExtensionsServiceProvider',\n
            'Yaro\TableBuilder\TableBuilderServiceProvider',\n\n
            aliases:\n
            'TableBuilder'  => 'Yaro\TableBuilder\Facades\TableBuilder',\n
            'Settings'      => 'Yaro\TableBuilder\Helpers\Settings',"
        );
        $this->ask('Done?');
        $this->info('bb gl');
    } // end doPrepareMisc
    
    private function doPrepareIntervention()
    {
        $this->info('Add following in app/config/app.php');
        $this->comment("providers: 'Intervention\Image\ImageServiceProvider',\naliases: 'Image' => 'Intervention\Image\Facades\Image',");
        
        if ($this->confirm('Done? [yes|no]')) {
            $this->info('publising config...');
            $this->call('config:publish', array('intervention/image'));
            $this->info('ok');
        } else {
            $this->error('Intervention package install aborting');
        }
    } // end doPrepareIntervention
    
    private function doPrepareSentry()
    {
        $this->info('Add following in app/config/app.php');
        $this->comment("providers: 'Cartalyst\Sentry\SentryServiceProvider',\naliases: 'Sentry' => 'Cartalyst\Sentry\Facades\Laravel\Sentry',");
        
        if ($this->confirm('Done? [yes|no]')) {
            $this->info('migrating...');
            $this->call('migrate', array('--package' => 'cartalyst/sentry'));
            $this->info('ok');
            
            $this->info('publising config...');
            $this->call('config:publish', array('cartalyst/sentry'));
            $this->info('ok');
        } else {
            $this->error('Sentry package install aborting');
        }
    } // end doPrepareSentry

}
