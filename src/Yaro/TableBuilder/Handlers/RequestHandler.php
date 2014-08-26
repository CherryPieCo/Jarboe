<?php namespace Yaro\TableBuilder\Handlers;

use Yaro\TableBuilder\TableBuilderController;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;


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
                
            case 'upload_photo':
                return $this->handlePhotoUpload();
            
            case 'upload_photo_wysiwyg':
                return $this->handlePhotoUploadFromWysiwyg();
                
            case 'change_direction':
                return $this->handleChangeDirection();
                
            case 'upload_file':
                return $this->handleFileUpload();
                
            default:
                return $this->handleShowList();
                break;
        }
    } // end handle
    
    protected function handleChangeDirection()
    {
        $order = array(
            'direction' => Input::get('direction'),
            'field' => Input::get('field')
        );
        
        $definitionName = $this->controller->getOption('def_name');
        $sessionPath = 'table_builder.'.$definitionName.'.order';
        Session::put($sessionPath, $order);

        $response = array(
            'url' => $this->controller->getOption('url')
        );
        return Response::json($response);
    } // end handleChangeDirection
    
    protected function handleFileUpload()
    {
        // FIXME:
        $file = Input::file('file');
        $extension = $file->getClientOriginalExtension();
        $fileName  = time() .'_'. $file->getClientOriginalName();
        
        $definitionName = $this->controller->getOption('def_name');
        $prefixPath = 'storage/tb-'.$definitionName.'/';
        $postfixPath = date('Y') .'/'. date('m') .'/'. date('d') .'/';
        $destinationPath = $prefixPath . $postfixPath;
        
        $status = $file->move($destinationPath, $fileName);
        
        $data = array(
            'status' => $status,
            'link'   => URL::to($destinationPath . $fileName),
            'short_link' => $destinationPath . $fileName,
        );
        return Response::json($data);
    } // end handlePhotoUpload
    
    protected function handlePhotoUpload()
    {
        // FIXME:
        $file = Input::file('image');
        $extension = $file->guessExtension();
        $fileName = md5_file($file->getRealPath()) .'_'. time() .'.'. $extension;
        
        $definitionName = $this->controller->getOption('def_name');
        $prefixPath = 'storage/tb-'.$definitionName.'/';
        $postfixPath = date('Y') .'/'. date('m') .'/'. date('d') .'/';
        $destinationPath = $prefixPath . $postfixPath;
        
        $status = $file->move($destinationPath, $fileName);
        
        $data = array(
            'status' => $status,
            'link'   => URL::to($destinationPath . $fileName),
            'short_link' => $destinationPath . $fileName,
            // FIXME: naughty hack
            'delimiter' => ','
        );
        return Response::json($data);
    } // end handlePhotoUpload
    
    protected function handlePhotoUploadFromWysiwyg()
    {
        // FIXME:
        $file = Input::file('image');
        $extension = $file->guessExtension();
        $fileName = md5_file($file->getRealPath()) .'_'. time() .'.'. $extension;
        
        $definitionName = $this->controller->getOption('def_name');
        $prefixPath = 'storage/tb-'.$definitionName.'/';
        $postfixPath = date('Y') .'/'. date('m') .'/'. date('d') .'/';
        $destinationPath = $prefixPath . $postfixPath;
        
        $status = $file->move($destinationPath, $fileName);
        
        $data = array(
            'status' => $status,
            'link'   => URL::to($destinationPath . $fileName)
        );
        return Response::json($data);
    } // end handlePhotoUploadFromWysiwyg
    
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
        $result['html'] = $this->controller->view->getRowHtml($result);

        return Response::json($result);
    } // end handleSaveEditFormAction

    protected function handleShowEditFormAction()
    {
        $idRow = $this->_getRowID();
        $this->checkEditPermission($idRow);

        $html = $this->controller->view->showEditForm($idRow);
        $data = array(
            'html' => $html,
            'status' => true
        );

        return Response::json($data);
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
            if ($value || $value === '0') {
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
