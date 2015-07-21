<?php

return array(
    
    'permissions' => array(
        /*
        'user' => array(
            'caption' => 'Users',
            'rights'  => array(
                'view'   => 'View',
                'create' => 'Create',
                'update' => 'Update',
                'delete' => 'Remove',
            ),
        ),
        */
    ),
    
    'check' => array(
        'users' => array(
            'create' => function() {
                return true;
            },
            'update' => function() {
                return true;
            },
            'delete' => function() {
                return true;
            },
        ),
        'groups' => array(
            'create' => function() {
                return true;
            },
            'update' => function() {
                return true;
            },
            'delete' => function() {
                return true;
            },
        ),
    ),
    
);
