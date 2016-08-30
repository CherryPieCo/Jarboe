<?php

return array(

    'view' => array(
        'list' => function(array $row) {},
        
        'form' => function(array $row) { // empty if create form
            return view('jarboe.c.users::patterns.user_password');
        }, // end view
    ),
    
    'handle' => array(
        'insert' => function($idRow, $patternValue, $values) {
            $password = trim($patternValue);
            if (!$password) {
                // FIXME: translations
                throw new \Yaro\Jarboe\Exceptions\JarboeValidationException(
                    'Пароль обязательное поле'
                );
            }
            
            $user = \Sentinel::findById($idRow);
            \Sentinel::update($user, compact('password'));
        }, // end insert
        
        'update' => function($idRow, $patternValue, $values) {
            $password = trim($patternValue);
            if (!$password) {
                return;
            }
            
            $user = \Sentinel::findById($idRow);
            \Sentinel::update($user, compact('password'));
        }, // end update
        
        'delete' => function($idRow) {}, // end delete
    ),
    
);
