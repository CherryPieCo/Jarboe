<?php

namespace Yaro\Jarboe\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;


class CreateSuperUserArtisanCommand extends Command 
{

    protected $name = 'tb:create-superuser';

    protected $description = "Create superuser in 'admin' group.";

    public function fire()
    {
        try {
            $adminGroup = \Sentry::findGroupByName('admin');
            
            $password = $this->option('pass') ? : str_random(12);
            $user = \Sentry::createUser(array(
                'email'     => $this->argument('email'),
                'password'  => $password,
                'activated' => true,
                'permissions' => array('superuser' => '1'),
            ));
        
            $user->addGroup($adminGroup);
            
            $this->info('pass: '. $password);
        } catch (\Cartalyst\Sentry\Groups\GroupNotFoundException $e) {
            $password = $this->option('pass') ? : str_random(12);
            $user = \Sentry::createUser(array(
                'email'     => $this->argument('email'),
                'password'  => $password,
                'activated' => true,
                'permissions' => array('superuser' => '1'),
            ));
        
            $adminGroup = \Sentry::createGroup(array(
                'name'        => 'admin',
                'permissions' => array(),
            ));
            $user->addGroup($adminGroup);
            
            $this->info('pass: '. $password);
        }
    } // end fire
    
    protected function getArguments()
    {
        return array(
            array('email', InputArgument::REQUIRED, 'User email.'),
        );
    } // end getArguments
    
    protected function getOptions()
    {
        return array(
            array('pass', null, InputOption::VALUE_OPTIONAL, 'User password.')
        );
    } // end getOptions
      
}
