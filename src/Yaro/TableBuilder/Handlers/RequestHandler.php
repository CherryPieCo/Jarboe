<?php namespace Yaro\TableBuilder\Handlers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;

class RequestHandler {

    protected $def;


    public function __construct($definition)
    {
        $this->def = $definition;
    } // end __construct

    public function process()
    {
        if (Input::has('query_type')) {
            switch (Input::get('query_type')) {
                case 'search':
                    return $this->handleSearchAction();
                    break;

                case 'fast_save':
                    return $this->handleFastSaveAction();
                    break;
                
                default:
                    # code...
                    break;
            }
            
        }
    } // end process

    protected function handleFastSaveAction()
    {
        $values = Input::all();
        $result = (new QueryHandler($this->def))->updateRow($values);

        return Response::json($result);
    } // end handleFastSaveAction

    protected function handleSearchAction()
    {
        $filters = $this->_prepareSearchFilters();
        $tbody = $this->getUpdatedTable($filters);
        
        return Response::json($tbody);
    } // end handleSearchAction

    protected function getUpdatedTable($filters)
    {
        $dir = 'table_templates';

        $table = View::make($dir .'.table_tbody');
        $table->def  = $this->def;
        $table->rows = (new QueryHandler($this->def))->getRows($filters);

        return $table->render();
    } // end getUpdatedTable

    private function _prepareSearchFilters()
    {
        $filters = Input::get('filter', array());

        $newFilters = array();
        foreach ($filters as $key => $value) {
            if ($value) {
                $newFilters[$key] = $value;
            }
        }

        return $newFilters;
    } // end prepareSearchFilters

}
