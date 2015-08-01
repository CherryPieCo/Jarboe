<?php

namespace Yaro\Jarboe\Component;


abstract class AbstractUtil
{
    
    /*
     * Check component requirements.
     * 
     * @return array
     */
    public static function check() 
    {
        return array();
    } // end check
    
    /*
     * Install component.
     * 
     * @param $command object
     * 
     * @return void
     */
    public static function install($command)
    {
        
    } // end install
    
    /*
     * Retrieve navigation menu item for appending.
     * 
     * @return void
     */
    public static function getNavigationMenuItem()
    {
        
    } // end getNavigationMenuItem
     
}
