<?php

namespace Yaro\TableBuilder;

class NavigationMenu 
{

    public function fetch()
    {
        $menu = array();

        $definition = \Config::get('table-builder::admin.menu');

        foreach ($definition as $key => $item) {
            $menu[] = $this->onMenuItem($item);
        }
        $menu = array_filter($menu);
        
        return \View::make('admin::partials.navigation_menu', compact('menu'))->render();
    } // end fetch
    
    private function onMenuItem($item)
    {
        if (isset($item['submenu'])) {
            $submenu = array();
            $isActiveParent = false;
            foreach ($item['submenu'] as $key => $subItem) {
                $sub = $this->onMenuItem($subItem);
                if ($sub) {
                    if (!isset($subItem['submenu'])) {
                        $sub['is_active'] = $this->isActiveURL($subItem);
                        if ($sub['is_active']) {
                            $isActiveParent = true;
                        }
                    }
                    
                    $submenu[] = $sub;
                }
            }
            $submenu = array_filter($submenu);
            
            unset($item['submenu']);
            if ($submenu) {
                $menuItem = array();
                
                $menuItem = $item;
                $menuItem['submenu'] = $submenu;
                $menuItem['is_active'] = $isActiveParent;
                return $menuItem;
            }
        } else {
            $isAllowed = $item['check'];
            if ($isAllowed()) {
                $item['is_active'] = $this->isActiveURL($item);
                $item['link'] = \URL::to(\Config::get('table-builder::admin.uri') . $item['link']);
                return $item;
            }
        }
    } // end onMenuItem
    
    public function checkPermissions()
    {
        $definition = \Config::get('table-builder::admin.menu');

        foreach ($definition as $key => $item) {
            $this->onCheckMenuItem($item);
        }
    } // end checkPermissions
    
    private function onCheckMenuItem($item)
    {
        if (isset($item['submenu'])) {
            foreach ($item['submenu'] as $key => $subItem) {
                $this->onCheckMenuItem($subItem);
            }
        } else {
            $menuLink = \URL::to(\Config::get('table-builder::admin.uri') . $item['link']);
            if (\Request::URL() == $menuLink) {
                $isAllowed = $item['check'];
                if (!$isAllowed()) {
                    \App::abort(404);
                }
            }
        }
    } // end onCheckMenuItem
    
    private function isActiveURL($item)
    {
        $menuLink = \URL::to(\Config::get('table-builder::admin.uri') . $item['link']);
        
        return \Request::URL() == $menuLink;
    } // end isActiveURL
}