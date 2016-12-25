<?php

namespace Yaro\Jarboe\Component;

use File;


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
    
    /*
     * Helper for copying files.
     */
    protected static function copyIfNotExist($command, $path, $filePath)
    {
        $folders = explode('/', $path);
        // remove file in path
        array_pop($folders);
        File::makeDirectory(base_path(implode('/', $folders)), 0775, true, true);

        if (File::exists(base_path($path))) {
            $command->info(' - ['. $path .'] exists. Skip copying.');
        } else {
            File::copy($filePath .'/'. $path, base_path($path));
            $command->info(' - ['. $path .'] copied.');
        }
    } // end copyIfNotExist
     
}
