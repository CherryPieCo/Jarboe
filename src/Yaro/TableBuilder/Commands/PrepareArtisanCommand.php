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
    } // end fire

}
