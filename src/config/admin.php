<?php

return array(

    'caption'  => 'Admin caption',
    'logo_url' => asset('packages/yaro/jarboe/img/logo.png'),
    'favicon_url' => asset('packages/yaro/jarboe/img/favicon/favicon.ico'),
    
    'uri' => '/admin',

    'user_name'  => function() {
        return Sentry::getUser()->first_name .' '. Sentry::getUser()->last_name;
    },
    'user_image' => function() {
        return 'https://www.gravatar.com/avatar/'. md5(Sentry::getUser()->email);
    },

    'menu' => array(
        array(
            'title' => 'Главная',
            'icon'  => 'home',
            'link'  => '/',
            'check' => function() {
                return true;
            }
        ),
        array(
            'title' => 'Структура сайта',
            'icon'  => 'navicon',
            'link'  => '/tree',
            'check' => function() {
                return true;
            }
        ),
        array(
            'title' => 'Настройки',
            'icon'  => 'cog',
            'link'  => '/settings',
            'check' => function() {
                return true;
            }
        ),
    ),

);
