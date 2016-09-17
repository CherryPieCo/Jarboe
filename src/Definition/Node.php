<?php

namespace Yaro\Jarboe\Definition;


class Node extends AbstractDefinition 
{
    protected function initDatabase($container)
    {
        $container->put('table', 'structure');
        $container->put('order', [
            'id' => 'ASC',
        ]);
        $container->put('paginate', 12);
    } // end initDatabase
    
    protected function initOptions($container)
    {
        $container->put('caption', 'Пользователи');
    } // end initOptions
    
    protected function initFields()
    {
        $this->createField('id', [
            'caption' => '#',
            'type' => 'readonly',
            'class' => 'col-id',
            'width' => '1%',
            'hide' => true,
            'is_sorting' => true
        ]);
        
        $this->createField('title', [
            'caption' => 'Заголовок',
            'type' => 'text',
        ]);
        
        $this->createField('slug', [
            'caption' => 'slug',
            'type' => 'text'
        ]);
    } // end initFields
    
    protected function initActions(&$container)
    {
        $container = [
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
        ];
    } // end initActions
    
    protected function initPosition($container)
    {
        $container->put('tabs', [
            'General' => [['first_name', 'last_name']],
        ]);
    } // end initPosition
    
    protected function callbackDeleteRow($id)
    {
        $user = \Sentinel::findUserById($id);
        $user->delete();
        
        return [
            'id'     => $id,
            'status' => true
        ];
    } // end callbackDeleteRow
    
}
