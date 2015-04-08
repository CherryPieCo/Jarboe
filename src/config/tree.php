<?php

return array(
    
    'is_active' => false,

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
