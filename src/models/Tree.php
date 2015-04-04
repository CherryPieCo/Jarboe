<?php

namespace Yaro\Jarboe;


class Tree extends \Baum\Node 
{
     
    protected $table = 'tb_tree';
    protected $parentColumn = 'parent_id';

    protected $_nodeUrl;
    
    public function setSlugAttribute($value)
    {
        $slug = \Jarboe::urlify($value);
        
        $slugCount = $this->where('parent_id', $this->parent_id)
                          ->whereRaw("slug REGEXP '^{$slug}(-[0-9]*)?$'")->count();
        $slug = $slugCount ? $slug .'-'. $slugCount : $slug;
        
        $this->attributes['slug'] = $slug;
    } // end setSlugAttribute

    public function hasTableDefinition()
    {
        $templates = \Config::get('jarboe::tree.templates');
        $template = \Config::get('jarboe::tree.default');
        if (isset($templates[$this->template])) {
            $template = $templates[$this->template];
        }

        return $template['type'] == 'table';
    } // end hasTableDefinition

    public function setUrl($url)
    {
        $this->_nodeUrl = $url;
    } // end setUrl

    public function getUrl()
    {
        if (!$this->_nodeUrl) {
            $this->_nodeUrl = $this->getGeneratedUrl();
        }
        return $this->_nodeUrl;
    } // end getUrl

    public function isActive()
    {
        return $this->is_active == 1;
    } // end isActive

    public function getGeneratedUrl()
    {
        $all = $this->getAncestorsAndSelf();

        $slugs = array();
        foreach ($all as $node) {
            if ($node->slug == '/') {
                continue;
            }
            $slugs[] = $node->slug;
        }

        return implode('/', $slugs);
    } // end getGeneratedUrl

}