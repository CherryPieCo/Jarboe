<?php

namespace Yaro\Jarboe\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;


class ComponentCommand extends Command 
{

    protected $signature = 'jarboe:component {action} {option?}';
    protected $description = "Components management: check|install.";
    private $components = [];

    public function fire()
    {
        $this->components = config('jarboe.components', []);
        
        $action = camel_case($this->argument('action'));
        $method = 'components'. $action;
        if (!method_exists($this, $method)) {
            $this->error('There is no ['. $action .'] action');
            die();
        }
        
        $this->$method();
    } // end fire
    
    public function componentsCheck()
    {
        foreach ($this->components as $component) {
            $util = '\Jarboe\Component\\'. $component .'\Util';
            $messages = $util::check();
            if ($messages) {
                $this->info($component .' component check:');
                foreach ($messages as $message) {
                    $this->error($message);
                }
            } else {
                $this->info($component .' component check: ok.');
            }
        }
    } // end componentsCheck
    
    public function componentsInstall()
    {
        foreach ($this->components as $component) {
            $this->info($component .' component install:');
            
            $util = '\Jarboe\Component\\'. $component .'\Util';
            $util::install($this);
            
            $this->info('ok.');
        }
    } // end componentsInstall
    
    protected function getArguments()
    {
        return array(
            array('action', InputArgument::REQUIRED, 'action'),
        );
    } // end getArguments
    
    protected function getOptions()
    {
        return array(
            //
        );
    } // end getOptions
      
}
