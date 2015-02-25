<?php

return array(
    
    'is_active' => true,

    'templates' => array(
        'default mainpage template' => array(
            'type' => 'node', // table | node
            'action' => 'Yaro\TableBuilder\TreeController@showThemeMain',
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
