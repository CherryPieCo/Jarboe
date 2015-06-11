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
        $html = '<div class="pull-left"><img style="height: 30px;" 
                      src="'. asset('packages/yaro/jarboe/img/logo.png') .'"></div>'
              . '<div class="pull-right" style="text-align: right;">'
              . '<p>Служба поддержки:</p>'
              . '<p><a href="mailto:support@vis-design.com">support@vis-design.com</a></p>'
              . '</div>';
        
        return $html;
    },
    'bottom_block' => function() {
        $html = '<p>Контактные данные:</p>'
              . '<p>0 800 ххх 44 88 | <a href="mailto:support@example.com">support@example.com</a></p>';
        
        return $html;
    },
    
    // callbacks
    'on_login' => function() {
    },
    'on_logout' => function() {
        return \Redirect::to('/');
    },
    
);
    