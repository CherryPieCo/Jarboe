<?php

return array(
    'db' => array(
        'table' => 'groups',
            'order' => array(
            'id' => 'ASC',
        ),
        'pagination' => array(
            'per_page' => 12,
            'uri' => '/admin/tb/groups',
        ),
    ),
    'options' => array(
        'caption' => 'Группы пользователи',
        'ident' => 'users-container',
        'form_ident' => 'users-form',
        'table_ident' => 'users-table',
        'action_url' => '/admin/handle/groups',
        'handler'    => 'GroupsTableHandler',
        'not_found'  => 'NOT FOUND',
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
        'name' => array(
            'caption' => 'Название',
            'type' => 'text',
            'filter' => 'text',
            'is_sorting' => true,
        ),
    ),
    
    'actions' => array(
        'search' => array(
            'caption' => 'Поиск',
        ),
        'insert' => array(
            'caption' => 'Добавить',
        ),
        'custom' => array(
            array(
                'caption' => 'Редактировать',
                'icon' => 'pencil',
                'link' => '/admin/tb/groups/%d',
                'params' => array(
                    'id'
                )
            )
        ),
        'delete' => array(
            'caption' => 'Удалить',
        ),
    ),
    
    'callbacks' => array(
        'handleDeleteRow' => function($id) {
            $group = \Sentry::findGroupById($id);
            $group->delete();
            
            return array(
                'id'     => $id,
                'status' => true
            );
        }, // end handleDeleteRow
    
        'onInsertButtonFetch' => function($def) {
            $url = \URL::to(Config::get('jarboe::admin.uri') . '/tb/groups/create');
            $caption = isset($def['caption']) ? $def['caption'] : 'Add';
            $html = '<a href="'. $url .'">
                    <button class="btn btn-default btn-sm" style="min-width: 66px;"
                             type="button">
                         '. $caption .'
                     </button>
                     </a>';
            
            return $html;
        }, // end onInsertButtonFetch
    ),
    
);