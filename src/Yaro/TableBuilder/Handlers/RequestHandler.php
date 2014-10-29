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
            
            case 'import':
                return $this->handleImport();
                break;
                
            case 'get_import_template':
                return $this->handleImportTemplateDownload();
                break;
                
            case 'export':
                return $this->handleExport();
                break;
                
            case 'set_per_page':
                return $this->handleSetPerPageAmountAction();
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
    
    protected function handleImportTemplateDownload()
    {
        $type = Input::get('type');
        $method = 'do'. ucfirst($type) .'TemplateDownload';
        
        $this->controller->import->$method();
    } // end handleImportTemplateDownload
    
    protected function handleImport()
    {
        $file   = Input::file('file');
        $type   = Input::get('type');
        $method = 'doImport'. ucfirst($type);
        $idents = array_keys(Input::get('b', array()));
        
        $res = $this->controller->import->$method($file);
        
        $response = array(
            'status' => $res
        );
        return Response::json($response);
    } // end handleImport
    
    protected function handleExport()
    {
        $type   = Input::get('type');
        $method = 'doExport'. ucfirst($type);
        $idents = array_keys(Input::get('b', array()));
        
        $this->controller->export->$method($idents);
    } // end handleExport

    protected function handleSetPerPageAmountAction()
    {
        $perPage = Input::get('per_page');
        
        $definitionName = $this->controller->getOption('def_name');
        $sessionPath = 'table_builder.'.$definitionName.'.per_page';
        Session::put($sessionPath, $perPage);
        
        $response = array(
            'url' => $this->controller->getOption('url')
        );
        return Response::json($response);
    } // end handleSetPerPageAmountAction
    
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
        
        if ($this->controller->hasCustomHandlerMethod('onFileUpload')) {
            $res = $this->controller->getCustomHandler()->onFileUpload($file);
            if ($res) {
                return $res;
            }
        }
        
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
    } // end handleFileUpload
    
    protected function handlePhotoUpload()
    {
        // FIXME:
        $ident = Input::get('ident');
        $file  = Input::file('image');
        $num   = Input::get('num');
        
        $field = $this->controller->getField($ident);
        
        if ($this->controller->hasCustomHandlerMethod('onPhotoUpload')) {
            $res = $this->controller->getCustomHandler()->onPhotoUpload($field, $file);
            if ($res) {
                return $res;
            }
        }
        
        $data = $field->doUpload($file);
        // HACK: for generating multiple image upload template | mb no need
        if ($num) {
            $data['num'] = $data;
        }
        
        return Response::json($data);
    } // end handlePhotoUpload
    
    protected function handlePhotoUploadFromWysiwyg()
    {
        // FIXME:
        $file = Input::file('image');
        
        if ($this->controller->hasCustomHandlerMethod('onPhotoUploadFromWysiwyg')) {
            $res = $this->controller->getCustomHandler()->onPhotoUploadFromWysiwyg($file);
            if ($res) {
                return $res;
            }
        }
        
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
            if (is_array($value)) {
                if (isset($value['from']) && $value['from']) {
                    $newFilters[$key]['from'] = $value['from'];
                }
                if (isset($value['to']) && $value['to']) {
                    $newFilters[$key]['to'] = $value['to'];
                }
            } else {
                if ($value || $value === '0') {
                    $newFilters[$key] = $value;
                }
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
