<?php

namespace Yaro\TableBuilder;


class Tree extends \Baum\Node 
{
     
    protected $table = 'tb_tree';
    protected $parentColumn = 'parent_id';

    public function hasTableDefinition()
    {
        $templates = \Config::get('table-builder::tree.templates', array());
        return $this->template;
    } // end hasTableDefinition 
}