<?php

return array(

    /*
     * Display 'remember me' checkbox on login page.
     */
    'is_active_remember_me'  => true,
    
    /*
     * Allow autocompletion on login page.
     */
    'is_active_autocomplete' => true,

    /*
     * Background image on login page.
     */
    'background_url' => function() {
        return asset('packages/yaro/jarboe/img/login-bg.jpg');
    },
    
    /*
     * Image on the top right corner of form.
     */
    'favicon_url' => function() {
        return asset('packages/yaro/jarboe/img/c-c-cat.gif');
    },
    
    /*
     * Displays content over the form.
     */
    'top_block' => function() {
    },
    
    /*
     * Displays content under the form.
     */
    'bottom_block' => function() {
    },
    
    /*
     * Callback after authentication.
     */
    'on_login' => function() {
    },
    
    /*
     * Callback after authentication.
     */
    'on_logout' => function() {
        return redirect('/');
    },
    
);
    