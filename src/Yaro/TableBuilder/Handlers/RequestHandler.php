<?php namespace Yaro\TableBuilder\Handlers;

use Yaro\TableBuilder\TableBuilderController;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;


class RequestHandler {

    protected $controller;


    public function __construct(TableBuilderController $controller)
    {
        $this->controller = $controller;
    } // end __construct

    public function handle()
    {
        switch (Input::get('query_type')) {
            case 'search':
                return $this->handleSearchAction();
                break;

            case 'fast_save':
                return $this->handleFastSaveAction();
                break;

            case 'show_edit_form':
                return $this->handleShowEditFormAction();
                break;

            case 'save_edit_form':
                return $this->handleSaveEditFormAction();
                break;

            case 'show_add_form':
                return $this->handleShowAddFormAction();
                break;

            case 'save_add_form':
                return $this->handleSaveAddFormAction();
                break;

            case 'delete_row':
                return $this->handleDeleteAction();
                break;   
            
            default:
                return $this->handleShowList();
                break;
        }
    } // end handle

    protected function handleDeleteAction()
    {
        $idRow = $this->_getRowID();
        $this->checkEditPermission($idRow);

        $result = $this->controller->query->deleteRow($idRow);

        return Response::json($result);
    } // end handleDeleteAction

    protected function handleShowAddFormAction()
    {
        $result = $this->controller->view->showEditForm();

        return Response::json($result);
    } // end handleShowAddFormAction

    protected function handleSaveAddFormAction()
    {
        $result = $this->controller->query->insertRow(Input::all());
        $result['html'] = $this->controller->view->getRowHtml($result);

        return Response::json($result);
    } // end handleSaveAddFormAction

    protected function handleSaveEditFormAction()
    {
        $idRow = $this->_getRowID();
        $this->checkEditPermission($idRow);

        $result = $this->controller->query->updateRow(Input::all());

        return Response::json($result);
    } // end handleSaveEditFormAction

    protected function handleShowEditFormAction()
    {
        $idRow = $this->_getRowID();
        $this->checkEditPermission($idRow);

        $result = $this->controller->view->showEditForm($idRow);

        return Response::json($result);
    } // end handleShowEditFormAction

    protected function checkEditPermission($id)
    {
        if (!$this->controller->isAllowedID($id)) {
            throw new \RuntimeException("Permission denied to perform edit for #{$id}.");
        }
    } // end checkEditPermission

    private function _getRowID()
    {
        if (Input::has('id')) {
            return Input::get('id');
        }
        throw new \RuntimeException("Undefined row id for action.");
    } // end _getRowID

    protected function handleShowList()
    {
        return array(
            $this->controller->view->showList(),
            $this->controller->view->showEditForm()
        );	
    } // end handleShowList

    protected function handleFastSaveAction()
    {
        $idRow = $this->_getRowID();
        $this->checkEditPermission($idRow);

        $result = $this->controller->query->updateFastRow(Input::all());

        return Response::json($result);
    } // end handleFastSaveAction

    protected function handleSearchAction()
    {
        $this->_prepareSearchFilters();

        $response = array(
            'url' => $this->controller->getOption('url')
        );
        return Response::json($response);
    } // end handleSearchAction

    private function _prepareSearchFilters()
    {
        $filters = Input::get('filter', array());

        $newFilters = array();
        foreach ($filters as $key => $value) {
            if ($value) {
                $newFilters[$key] = $value;
            }
        }

        if ($this->controller->hasCustomHandlerMethod('onPrepareSearchFilters')) {
            $this->controller->getCustomHandler()->onPrepareSearchFilters($newFilters);
        }

        $definitionName = $this->controller->getOption('def_name');
        $sessionPath = 'table_builder.'.$definitionName.'.filters';
        Session::put($sessionPath, $newFilters);
    } // end _prepareSearchFilters


}
