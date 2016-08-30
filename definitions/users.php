<?php

return array(

    'db' => array(
        'table' => 'users',
            'order' => array(
            'id' => 'ASC',
        ),
        'pagination' => array(
            'per_page' => [
                12 => 12, 
                24 => 24, 
                50 => 50
            ],
        ),
    ),
    'options' => array(
        'caption' => 'Пользователи', 
    ),
    
    'position' => array(
        'tabs' => array(
            'Инфо' => array(['first_name', 'last_name'], 'email', 'pattern.user_password'),
            'Права' => array('pattern.user_permissions'),
            'Активность' => array('pattern.user_activation'),
        )
    ),
    
    'fields' => array(
        'id' => array(
            'caption' => '#',
            'type' => 'readonly',
            'class' => 'col-id',
            'width' => '1%',
            'is_sorting' => true,
            'hide' => true,
        ),
        'email' => array(
            'caption' => 'Email',
            'type' => 'text',
            'filter' => 'text',
            'is_sorting' => true,
            'validation' => array(
                'server' => array(
                    'rules' => 'email|required'
                ),
                'client' => array(
                    'rules' => array(
                        'required' => true,
                        'email'    => true
                    ),
                    'messages' => array(
                        'required' => 'Обязательно к заполнению',
                        'email'    => 'Невалидный email'
                    )
                )
            ),
        ),
        'first_name' => array(
            'caption' => 'Имя',
            'type'    => 'text',
            'filter' => 'text',
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
        'last_name' => array(
            'caption' => 'Фамилия',
            'type'    => 'text',
            'filter' => 'text',
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
        'pattern.user_permissions' => [
            'caption' => 'Права',
            'hide_list' => true,
        ],
        'pattern.user_activation' => [
            'caption' => 'Активация',
            'hide_list' => true,
        ],
        'pattern.user_password' => [
            'caption' => 'Пароль',
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
        'handleDeleteRow' =>function($id) {
            $user = \Sentinel::findUserById($id);
            $user->delete();
            
            return array(
                'id'     => $id,
                'status' => true
            );
        }, // end handleDeleteRow
    ),
);