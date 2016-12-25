<?php

return array(

    /*
     * Used for <title> in admin pages.
     */
    'caption'  => 'Jarboe',
    
    /*
     * Favicon path, used in admin pages.
     */
    'favicon_url' => '/packages/yaro/jarboe/img/favicon/favicon.png',
    
    /*
     * Admin pages uri
     */
    'uri' => '/admin',

    /*
     * User name for logged in account info.
     */
    'user_name'  => function() {
        return Sentinel::getUser()->first_name .' '. Sentinel::getUser()->last_name;
    },
    
    /*
     * User avatar for logged in account info.
     */
    'user_image' => function() {
        return 'https://www.gravatar.com/avatar/'. md5(Sentinel::getUser()->email);
    },

    /*
     * Navigation menu elements.
     * title   - title of the navigation element, can be anonymous function (required);
     * link    - uri of its url in admin page (required);
     * check   - anonymous function to check accessibility for current page (required);
     * icon    - name of Font Awesome icon, that prepends title (optional);
     * submenu - used for non-clickable menu item, that containing clickable menu items.
     *           'link' and 'check' keys are not used for current navigation item;
     *         -- ex:
     *           'menu' => [
     *               'title' => 'Title',
     *               'icon' => 'navicon',
     *               'submenu' => [
     *                   [
     *                       'title' => 'Sub #1',
     *                       'link' => '/sub-one',
     *                       'check' => function () {
     *                           return true;
     *                       }
     *                   ],
     *                   [
     *                       'title' => 'Sub #2',
     *                       'link' => '/sub-two',
     *                       'icon' => 'hashtag',
     *                       'check' => function () {
     *                           return true;
     *                       }
     *                   ],
     *               ],
     *           ]
     */
    'menu' => array(
        array(
            'title' => 'Dashboard',
            'icon'  => 'home',
            'link'  => '/',
            'check' => function() {
                return true;
            }
        ),
        array(
            'title' => 'Settings',
            'icon'  => 'cog',
            'link'  => '/settings',
            'check' => function() {
                return true;
            }
        ),
    ),

);
