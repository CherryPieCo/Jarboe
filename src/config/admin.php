<?php

return array(

    'title' => 'TB Admin',
    
    'uri' => '/admin',
    
    'user_name'  => function() {
        return 'Default Username';
    },
    'user_image' => function() {
        return 'http://www.cmakers.org/Img/kitty_artwork_04.gif';
    },

    'yandex_api_translation_key' => '', 

    'menu' => array(
        array(
            'title' => 'Главная',
            'icon'  => 'home',
            'link'  => '/',
            'check' => function() {
                return true;
            }
        ),
    ),
    
);
