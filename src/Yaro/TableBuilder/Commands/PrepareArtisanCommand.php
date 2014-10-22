<?php

namespace Yaro\TableBuilder\Commands;

use Illuminate\Console\Command;


class PrepareArtisanCommand extends Command 
{

    protected $name = 'tb:prepare';

    protected $description = 'TB: prepare package.';

    public function fire()
    {
        if (is_dir(app_path() . '/tb-definitions')) {
            $this->info('Folder /app/tb-definitions is existing. Use it to store your table definitions.');
            return;
        }
        
        mkdir(app_path() . '/tb-definitions');
        
        $this->info('Folder /app/tb-definitions successfully created. Place there your table definitions.');
        
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
                $table->decimal('amount', 10, 7);
                $table->decimal('amount', 10, 7);
            });
        }
        
    } // end fire

}
