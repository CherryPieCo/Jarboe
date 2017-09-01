<?php

return array(

    'db' => array(
        'table' => 'roles',
            'order' => array(
            'id' => 'ASC',
        ),
        'pagination' => array(
            'per_page' => 12,
        ),
    ),
    'options' => array(
        'caption' => 'Группы пользователей',
    ),
    
    'position' => array(
        'tabs' => array(
            'Info' => array('slug', 'name'),
            'Permissions' => array('pattern.group_permissions'),
        )
    ),
    
    'fields' => array(
        'id' => array(
            'caption' => '#',
            'type' => 'readonly',
            'class' => 'col-id',
            'width' => '1%',
            'hide' => true,
            'is_sorting' => true,
        ),
        'slug' => array(
            'caption' => 'Идентификатор',
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
                        'required' => 'Обязательно к заполнению'
                    )
                )
            ),
        ),
        'name' => array(
            'caption' => 'Название',
            'type' => 'text',
            'filter' => 'text',
            'is_sorting' => true,
        ),
        'pattern.group_permissions' => [
            'caption' => 'Права',
            'hide_list' => true,
        ],
    ),
    
    'actions' => array(
        'search' => array(
            'caption' => 'Поиск',
        ),
        'insert' => array(
            'caption' => 'Добавить',
        ),
        'update' => array(
            'caption' => 'Редактировать',
        ),
        'delete' => array(
            'caption' => 'Удалить',
        ),
    ),
    
    'callbacks' => array(
        'handleDeleteRow' => function($id) {
            $role = \Sentinel::findRoleById($id);
            $role->delete();
            
            return array(
                'id'     => $id,
                'status' => true
            );
        }, // end handleDeleteRow
    ),
    
);