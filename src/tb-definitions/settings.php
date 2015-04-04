<?php

return array(
    'db' => array(
        'table' => 'settings',
        'order' => array(
            'id' => 'ASC',
        ),
        'pagination' => array(
            'per_page' => 12,
            'uri' => '/admin/settings',
        ),
    ),
    
    'options' => array(
        'caption' => 'Settings',
        'ident' => 'settings-container',
        'form_ident' => 'settings-form',
        'table_ident' => 'settings-table',
        'action_url' => '/admin/handle/settings',
        'handler' => 'Yaro\Jarboe\Helpers\TableHandlers\Settings',
        'not_found' => 'NOT FOUND',
    ),
    
    'fields' => array(
        'id' => array(
            'caption' => '#',
            'type' => 'readonly',
            'class' => 'col-id',
            'width' => '1%',
            'hide' => true,
            'is_sorting' => true
        ),
        'name' => array(
            'caption' => 'Ident',
            'type' => 'text',
            'filter' => 'text',
            'is_sorting' => true,
            'validation' => array(
                'server' => array(
                    'rules' => 'required'
                ),
                'client' => array(
                    'rules' => array(
                        'required' => true
                    ),
                    'messages' => array(
                        'required' => 'The field is required'
                    )   
                )
            )
        ),
        'value' => array(
            'caption' => 'Value',
            'type' => 'text',
            'filter' => 'text',
            'is_sorting' => true,
            'validation' => array(
                'server' => array(
                    'rules' => 'required'
                ),
                'client' => array(
                    'rules' => array(
                        'required' => true
                    ),
                    'messages' => array(
                        'required' => 'The field is required'
                    )   
                )
            )
        ),
        'description' => array(
            'caption' => 'Description',
            'type' => 'text',
            'filter' => 'text'
        ),
    ),
    
    'filters' => array(
    ),
    
    'actions' => array(
        'search' => array(
            'caption' => 'Search',
        ),
        'insert' => array(
            'caption' => 'Create',
            'check' => function() {
                return true;
            }
        ),
        'update' => array(
            'caption' => 'Update',
            'check' => function() {
                return true;
            }
        ),
        'delete' => array(
            'caption' => 'Remove',
            'check' => function() {
                return true;
            }
        ),
    ),
);