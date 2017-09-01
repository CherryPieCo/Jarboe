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
        $container->put('caption', 'Node');
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
            'caption' => 'Title',
            'type' => 'text',
        ]);
        
        $templates = \Yaro\Jarboe\Models\Structure::getTemplates();
        $this->createField('template', [
            'caption' => 'Template',
            'type' => 'select',
            'options' => array_combine(
                array_keys($templates), 
                array_column($templates, 'caption')
            ),
        ]);
        
        $this->createField('slug', [
            'caption' => 'Slug',
            'type' => 'text'
        ]);
        
        $this->createField('content', [
            'caption' => 'Content',
            'type' => 'wysiwyg'
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
            'General' => ['title', ['template', 'slug']],
            'Content' => ['content'],
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
