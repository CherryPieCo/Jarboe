<?php

return array(

    'uri' => '/admin',
    
    'user_name'  => 'Default Username',
    'user_image' => 'http://www.cmakers.org/Img/kitty_artwork_04.gif',

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
