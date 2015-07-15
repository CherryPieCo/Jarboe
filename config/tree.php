<?php

return array(
    
    'is_active' => false,
    
    'model' => 'Yaro\Jarboe\Tree',
    
     // !isset options - tinyint(1)
     // isset options  - set
    'node_active_field' => array(
        'field' => 'is_active',
    ),
    /*
    'node_active_field' => array(
        'field' => 'active',
        'options' => array(
            // set var => caption
            'ru' => 'Рус',
            'en' => 'Eng',
        ),
    ),
    */

    'templates' => array(
        'default mainpage template' => array(
            'type' => 'node', // table | node
            'action' => 'Yaro\Jarboe\TreeController@showThemeMain',
            'definition' => '',
            'node_definition' => 'node',
            'check' => function() {
                return true;
            },
        ),
        'page template sample' => array(
            'type' => 'node', 
            'action' => 'HomeController@showPage',
            'definition' => '',
            'node_definition' => 'node',
            'check' => function() {
                return true;
            },
        ),
    ),
    
    'default' => array(
        'type' => 'node', 
        'action' => 'HomeController@showPage',
        'definition' => 'node',
        'node_definition' => 'node',
    ),
    
    
    
);
