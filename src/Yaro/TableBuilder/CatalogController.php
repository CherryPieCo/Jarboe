<?php 

namespace Yaro\TableBuilder;

use Illuminate\Support\Facades\Input;


class CatalogController 
{
    protected $name;
    protected $options;
    
    
    public function __construct($name, $options)
    {
        $this->name    = $name;
        $this->options = $options;
    } // end __construct

    public function handle()
    {
        switch (Input::get('query_type')) {
            default:
                return $this->handleShowCatalog();
                break;
        }
    } // end handle
    
    private function handleShowCatalog()
    {
        $model = $this->name;
        
        return $model::all()->toHierarchy();
    } // end handleShowCatalog

}
    