<?php

namespace Yaro\Jarboe;


class Informer
{
    
    public function fetch()
    {
        list($total, $tabs) = $this->getPreparedTabs();
        if (!$tabs) {
            return '';
        }
        
        return \View::make('admin::informer.main', compact('total', 'tabs'));
    } // end fetch
    
    public function getContentByIndex($index)
    {
        list(, $tabs) = $this->getPreparedTabs();
        
        return $tabs[$index]['info']['content']();
    } // end getContentByIndex
    
    public function getCounts()
    {
        list($total, $tabs) = $this->getPreparedTabs();
        
        $counts = array();
        foreach ($tabs as $tab) {
            $counts[] = $tab['info']['count'];
        }
        
        return array($total, $counts);
    } // end getCounts
    
    protected function getPreparedTabs()
    {
        $tabs = \Config::get('jarboe::informer.tabs', array());
        $prepared = array();
        $total = 0;
        foreach ($tabs as $tab) {
            $isAllow = $tab['check'];
            if ($isAllow()) {
                $tab['info']['count'] = $tab['info']['count']();
                $total += $tab['info']['count'];
                
                $prepared[] = $tab;
            }
        }
        
        return array($total, $prepared);
    } // end getPreparedTabs
    
}
