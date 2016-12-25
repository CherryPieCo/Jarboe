<?php

return array(
    
    'view' => array(
        'list' => function(array $row) {}, // end list
        
        'form' => function(array $row) { // empty if create form
            $isActive = false;
            if ($row) {
                $user = \Sentinel::findById($row['id']);
                $isActive = \Activation::completed($user);
            }

            return view('jarboe.c.users::patterns.user_activation', compact('isActive'));
        }, // end view
    ),
    
    'handle' => array(
        'insert' => function($idRow, $patternValue, $values) {
            if ($patternValue == 'deactivate') {
                return;
            }
            
            $user = \Sentinel::findById($idRow);
            $activation = \Activation::create($user);
            \Activation::complete($user, $activation->code);
        }, // end insert
        
        'update' => function($idRow, $patternValue, $values) {
            $user = \Sentinel::findById($idRow);
            $activation = \Activation::completed($user);
            
            if (!$activation && $patternValue == 'deactivate') {
                return;
            } elseif ($activation && $patternValue == 'deactivate') {
                \Activation::remove($user);
            } elseif (!$activation && $patternValue == 'activate') {
                $activation = \Activation::create($user);
                \Activation::complete($user, $activation->code);
            }
        }, // end update
        
        'delete' => function($idRow) {}, // end delete
    ),
    
);
