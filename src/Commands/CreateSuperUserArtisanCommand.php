<?php

namespace Yaro\Jarboe\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Sentinel;
use Activation;


class CreateSuperUserArtisanCommand extends Command 
{

    protected $name = 'jarboe:create-user';

    protected $description = "Create user with 'admin' role.";

    public function fire()
    {
        $email = $this->ask('Email');
        $password = str_random(12);
        if ($this->confirm('Do you want your password?')) {
            $password = $this->ask('Password');
        }
        $firstName = $this->ask('First name');
        $lastName  = $this->ask('Last Name');
        
        $permissions = [];
        if ($this->confirm('Is superuser?')) {
            $permissions['superuser'] = true;
        }
        
        $user = Sentinel::create(array(
            'email'       => $email,
            'password'    => $password,
            'first_name'  => $firstName,
            'last_name'   => $lastName,
            'permissions' => $permissions,
        ));
        
        $activation = Activation::create($user);
        Activation::complete($user, $activation->code);
        
        $role = Sentinel::findRoleBySlug('admin');
        if (!$role) {
            $role = Sentinel::getRoleRepository()->createModel()->create([
                'name' => 'Administrator',
                'slug' => 'admin',
            ]);
        }
        $role->users()->attach($user);
        
        $this->info($firstName .' '. $lastName .' credentials:');
        $this->info('login: '. $email);
        $this->info('pass:  '. $password);
    } // end fire
    
    protected function getArguments()
    {
        return array(
            //array('email', InputArgument::REQUIRED, 'User email.'),
        );
    } // end getArguments
    
    protected function getOptions()
    {
        return array(
            //array('pass', null, InputOption::VALUE_OPTIONAL, 'User password.'),
        );
    } // end getOptions
      
}
