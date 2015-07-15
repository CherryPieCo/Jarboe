<?php

namespace Yaro\Jarboe\Commands;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;


class PrepareArtisanCommand extends Command 
{

    protected $name = 'tb:prepare';

    protected $description = 'Prepare package.';

    public function fire()
    {
        if (is_dir(app_path() . '/tb-definitions')) {
            $this->info('Folder /app/tb-definitions is existing. Use it to store your table definitions.');
        } else {
            mkdir(app_path() . '/tb-definitions');
            $this->info('Folder /app/tb-definitions successfully created. Place there your table definitions.');
        }
        
        if ($this->confirm('Create `settings` table with definition? [y|n]')) {
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
            mkdir(app_path() . '/tb-definitions/patterns');
            copy(
                __DIR__ . '/../../../tb-definitions/patterns/example.php', 
                app_path() . '/tb-definitions/patterns/example.php'
            );
        }

        if ($this->confirm('Copy tree definitions? [y|n]')) {
            mkdir(app_path() . '/tb-definitions/tree');
            $res = copy(
                __DIR__ . '/../../../tb-definitions/tree/node.php', 
                app_path() . '/tb-definitions/tree/node.php'
            );
            if ($res) {
                $this->info('Successfully tree node definition');
            } else {
                $this->error('Unable to copy tree node definition. Copy it manually.');
            }
        }

        if ($this->confirm('Create `tb_tree` table to handle site structure? [y|n]')) {
            \Schema::create('tb_tree', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('parent_id')->nullable()->index();
                $table->integer('lft')->nullable()->index();
                $table->integer('rgt')->nullable()->index();
                $table->integer('depth')->nullable();

                $table->string('title', 255);
                $table->string('slug', 255);
                $table->string('template', 120);
                $table->tinyInteger('is_active');
                $table->string('seo_title', 255);
                $table->string('seo_description', 255);
                $table->string('seo_keywords', 255);

                $table->timestamps();
            });

            $tree = array(
                array(
                    'id' => 1, 
                    'title' => 'Home', 
                    'slug' => '/', 
                    'template' => 'default mainpage template',
                    'is_active' => 1,
                )
            );
            \Yaro\Jarboe\Tree::buildTree($tree);
        }

        if ($this->confirm('Create `translations` table to handle templates localization? [y|n]')) {
            \Schema::create('translations', function(Blueprint $table) {
                $table->increments('id');

                $table->string('namespace', 255)->default('messages');;
                $table->string('key', 255);
                
                foreach (\Config::get('jarboe::translate.locales') as $locale) {
                    $table->string('value_'. $locale, 255);
                }
            });
        }

        /*
        if ($this->confirm('Create `ip_geo_locations` table? [y|n]')) {
            \Schema::create('ip_geo_locations', function($table) {
                $table->increments('id')->unsigned();
                $table->char('ip', 32)->unique();
                $table->char('town', 60);
                $table->decimal('longitude', 10, 7);
                $table->decimal('latitude', 10, 7);
            });
        }
        */
        if ($this->confirm('Replace global.php? [y|n]')) {
            $res = unlink(app_path() . '/start/global.php');
            if ($res) {
                $this->info('successfully unlinked old app/start/global.php');
                $res = copy(
                    __DIR__ . '/../../../misc/global.php', 
                    app_path() . '/start/global.php'
                );
                if ($res) {
                    $this->info('Successfully copied new global.php');
                } else {
                    $this->error('Unable to copy new global.php. Copy it manually.');
                }
            } else {
                $this->error('Unable to unlink app/start/global.php');
            }
        }
        
        if ($this->confirm('Copy base admin controller? [y|n]')) {
            $res = copy(
                __DIR__ . '/../../../misc/TableAdminController.php', 
                app_path() . '/controllers/TableAdminController.php'
            );
            if ($res) {
                $this->info('Successfully copied TableAdminController.php');
            } else {
                $this->error('Unable to copy TableAdminController.php. Copy it manually.');
            }
        }

        if ($this->confirm('Copy routes for backend? [y|n]')) {
            $res = copy(
                __DIR__ . '/../../../misc/routes_backend.php', 
                app_path() . '/routes_backend.php'
            );
            if ($res) {
                $this->info('Successfully copied routes_backend.php');
            } else {
                $this->error('Unable to copy routes_backend.php. Copy it manually.');
            }
        }
        
        if ($this->confirm('Copy error views? [y|n]')) {
            // XXX:
            mkdir(app_path() . '/views/errors', 0755);
            $res = copy(
                __DIR__ . '/../../../misc/errors/404.blade.php', 
                app_path() . '/views/errors/404.blade.php'
            );
            if ($res) {
                $this->info('Successfully copied error templates');
            } else {
                $this->error('Unable to copy error templates. Copy it manually.');
            }
        }

        $this->info('ok');

        /*
        if ($this->confirm('Prepare Sentry package? [y|n]')) {
            $this->doPrepareSentry();
        }
        
        if ($this->confirm('Prepare Intervention package? [y|n]')) {
            $this->doPrepareIntervention();
        }
        */
        //$this->doPrepareMisc();
    } // end fire
    
    private function doPrepareMisc()
    {
        $this->info('Add following in app/config/app.php');
        $msg = "providers:\n"
             . "'Radic\BladeExtensions\BladeExtensionsServiceProvider',\n"
             . "'Yaro\Jarboe\JarboeServiceProvider',\n\n"
             . "aliases:\n"
             . "'Jarboe'  => 'Yaro\Jarboe\Facades\Jarboe',\n"
             . "'Settings'      => 'Yaro\Jarboe\Helpers\Settings',";
            
        $this->comment($msg);
        $this->ask('Done? ');
        $this->info('bb gl');
    } // end doPrepareMisc
    
    private function doPrepareIntervention()
    {
        $this->info('Add following in app/config/app.php');
        $this->comment("providers: 'Intervention\Image\ImageServiceProvider',\naliases: 'Image' => 'Intervention\Image\Facades\Image',");
        
        if ($this->confirm('Done? [y|n]')) {
            $this->info('publising config...');
            $this->call('config:publish', array('package' => 'intervention/image'));
            $this->info('ok');
        } else {
            $this->error('Intervention package install aborting');
        }
    } // end doPrepareIntervention
    
    private function doPrepareSentry()
    {
        $this->info('Add following in app/config/app.php');
        $this->comment("providers: 'Cartalyst\Sentry\SentryServiceProvider',\naliases: 'Sentry' => 'Cartalyst\Sentry\Facades\Laravel\Sentry',");
        
        if ($this->confirm('Done? [y|n]')) {
            $this->info('migrating...');
            $this->call('migrate', array('--package' => 'cartalyst/sentry'));
            $this->info('ok');
            
            $this->info('publising config...');
            $this->call('config:publish', array('package' => 'cartalyst/sentry'));
            $this->info('ok');
        } else {
            $this->error('Sentry package install aborting');
        }
    } // end doPrepareSentry

}
