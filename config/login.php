<?php

return array(

    'is_active_remember_me'  => true,
    'is_active_autocomplete' => true,

    'background_url' => function() {
        return asset('packages/yaro/jarboe/img/login-bg.jpg');
    },
    'favicon_url' => function() {
        return asset('packages/yaro/jarboe/img/c-c-cat.gif');
    },
    
    'top_block' => function() {
    },
    'bottom_block' => function() {
    },
    
    // callbacks
    'on_login' => function() {
    },
    'on_logout' => function() {
        return \Redirect::to('/');
    },
    
);
    