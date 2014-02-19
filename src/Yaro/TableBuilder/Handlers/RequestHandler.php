<?php namespace Yaro\TableBuilder\Handlers;

use Yaro\TableBuilder\TableBuilderController;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;


class RequestHandler {

    protected $controller;


    public function __construct(TableBuilderController $controller)
    {
        $this->controller = $controller;
    } // end __construct

    public function process()
    {
        switch (Input::get('query_type')) {
            case 'search':
                return $this->handleSearchAction();
                break;

            case 'fast_save':
                return $this->handleFastSaveAction();
                break;

            case 'show_edit':
                return $this->handleShowEditFormAction();
                break;
            
            default:
                return $this->handleShowList();
                break;
        }
    } // end process

    protected function handleShowEditFormAction()
    {
        $idRow = $this->_getEditFormID();
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

    private function _getEditFormID()
    {
        if (Input::has('id')) {
            return Input::get('id');
        }
        throw new \RuntimeException("Undefined row id for edit form.");
    } // end _getEditFormID

    protected function handleShowList()
    {
        return $this->controller->view->showList();
    } // end handleShowList

    protected function handleFastSaveAction()
    {
        $idRow = $this->_getEditFormID();
        $this->checkEditPermission($idRow);

        $result = $this->controller->query->updateRow(Input::all());

        return Response::json($result);
    } // end handleFastSaveAction

    protected function handleSearchAction()
    {
        $tbody = $this->controller->view->getUpdatedTable();
        $pagination = $this->controller->view->getPagination();

        $response = array(
            'tbody'      => $tbody,
            'pagination' => $pagination
        );

        return Response::json($response);
    } // end handleSearchAction



}
