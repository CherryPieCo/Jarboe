<?php

namespace Yaro\TableBuilder\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;


class CreateAdminUserArtisanCommand extends Command 
{

    protected $name = 'tb:create-admin-user';

    protected $description = "TB: create user in 'admin' group.";

    public function fire()
    {
        if ($this->confirm('Is admin group existing? [yes|no]')) {
            $password = $this->option('pass') ? : str_random(12);
            $user = \Sentry::createUser(array(
                'email'     => $this->argument('email'),
                'password'  => $password,
                'activated' => true,
            ));
        
            $adminGroup = \Sentry::findGroupByName('admin');
            $user->addGroup($adminGroup);
            
            $this->info('pass: '. $password);
        } else {
            $password = $this->option('pass') ? : str_random(12);
            $user = \Sentry::createUser(array(
                'email'     => $this->argument('email'),
                'password'  => $password,
                'activated' => true,
            ));
        
            $group = \Sentry::createGroup(array(
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
