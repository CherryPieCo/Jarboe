<?php namespace Yaro\TableBuilder\Handlers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;


class RequestHandler {

    protected $controller;


    public function __construct($controller)
    {
        $this->controller = $controller;
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
        $result = $this->controller->query->updateRow(Input::all());

        return Response::json($result);
    } // end handleFastSaveAction

    protected function handleSearchAction()
    {
        $tbody = $this->controller->view->getUpdatedTable();

        return Response::json($tbody);
    } // end handleSearchAction



}
