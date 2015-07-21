<?php

namespace Yaro\Jarboe\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;


class ComponentCommand extends Command 
{

    //protected $name = 'jarboe:component';
    protected $signature = 'email:send {action} {option?}';

    protected $description = "Components management.";

    public function fire()
    {
        $action = mb_strtolower($this->argument('action'));
        $method = $action .'Action';
        if (!method_exists($this, $method)) {
            $this->error('There is no ['. $action .'] action');
            die();
        }
        
        $this->$method();
    } // end fire
    
    protected function getArguments()
    {
        return array(
            array('action', InputArgument::REQUIRED, 'action'),
        );
    } // end getArguments
    
    protected function getOptions()
    {
        return array(
            //array('pass', null, InputOption::VALUE_OPTIONAL, 'User password.'),
        );
    } // end getOptions
      
}
