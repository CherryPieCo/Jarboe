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
            Schema::create('settings', function($table) {
                $table->increments('id');
                $table->char('name', 255);
                $table->char('value', 255);
                $table->char('description', 255);
            });
            copy(
                __DIR__ . '/../../../tb-definitions/settings.php', 
                app_path() . '/tb-definitions/settings.php'
            );
        }
        
    } // end fire

}
