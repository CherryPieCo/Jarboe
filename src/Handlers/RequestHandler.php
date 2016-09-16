<?php 

namespace Yaro\Jarboe\Handlers;

use Yaro\Jarboe\JarboeController;

class RequestHandler 
{

    protected $controller;


    public function __construct(JarboeController $controller)
    {
        $this->controller = $controller;
    } // end __construct

    public function handle()
    {
        if (request()->get('edit')) {
            return $this->handleShowEditFormPage(request()->get('edit'));
        } elseif (request()->has('make')) {
            return $this->handleShowEditFormPage();
        }
        
        $method = camel_case('handle_'. request()->get('query_type'));
        if (method_exists($this, $method) && $method != 'handle') {
            return $this->$method();
        }
        
        return $this->handleShowList();
    } // end handle
    
    private function handleFileStorage()
    {
        return $this->controller->fileStorage->handle();
    } // end handleFileStorage
    
    private function handleImageStorage()
    {
        return $this->controller->imageStorage->handle();
    } // end handleImageStorage
    
    private function handleSaveInlineForm()
    {
        $this->checkEditPermission();
        
        $idRow = $this->getRowID();
        $fieldType = request()->get('__field_type');
        
        $field = $this->controller->getField($fieldType);
        $errors = $field->doSaveInlineEditForm($idRow, request()->all());
        
        return response()->json(array(
            'status' => empty($errors),
            'errors' => $errors,
        ));
    } // end handleSaveInlineForm
    
    protected function handleManyToManyAjaxSearch()
    {
        $query = request()->get('q');
        $limit = request()->get('limit');
        $page  = request()->get('page');
        $ident = request()->get('ident');
        
        $field = $this->controller->getField($ident);
        
        $data = $field->getAjaxSearchResult($query, $limit, $page);
        
        return response()->json($data);
    } // end handleManyToManyAjaxSearch
    
    protected function handleChangeOrder()
    {
        parse_str(request()->get('order'), $order);
        $order = $order['sort'];
        
        $definition = $this->controller->getDefinition();
        
        $info = $definition['db']['pagination']['per_page'];
        if (is_array($info)) {
            $definitionName = $this->controller->getOption('def_name');
            $sessionPath = 'table_builder.'.$definitionName.'.per_page';
            $perPage = session()->get($sessionPath);
            if (!$perPage) {
                $keys = array_keys($info);
                $perPage = $keys[0];
            }
        } else {
            $perPage = $info;
        }
        
        // FIXME: make page param available
        $lowest = (request()->get('page', 1) * $perPage) - $perPage;
        
        foreach ($order as $id) {
            ++$lowest;
            \DB::table($definition['db']['table'])->where('id', $id)->update(array(
                'priority' => $lowest
            ));
        }
        
        return response()->json(array(
            'status' => true
        ));
    } // end handleChangeOrder
    
    protected function handleMultiAction()
    {
        // FIXME: move to separate class
        $def = $this->controller->getDefinition();
        
        $type = request()->get('type');
        $action = $def['multi_actions'][$type];
        
        $isAllowed = $action['check'];
        if (!$isAllowed()) {
            throw new \RuntimeException('Multi action not allowed: '. $type);
        }
        
        $ids = request()->get('multi_ids', array());
        $handlerClosure = $action['handle'];
        $data = $handlerClosure($ids);
        
        $data['ids'] = $ids;
        $data['is_hide_rows'] = false;
        if (isset($action['is_hide_rows'])) {
            $data['is_hide_rows'] = $action['is_hide_rows'];
        }
        
        return response()->json($data);
    } // end handleMultiAction
    
    protected function handleMultiActionWithOption()
    {
        // FIXME: move to separate class
        $def = $this->controller->getDefinition();
        
        $type = request()->get('type');
        $option = request()->get('option');
        $action = $def['multi_actions'][$type];
        
        $isAllowed = $action['check'];
        if (!$isAllowed()) {
            throw new \RuntimeException('Multi action not allowed: '. $type);
        }
        
        $ids = request()->get('multi_ids', array());
        $handlerClosure = $action['handle'];
        $data = $handlerClosure($ids, $option);
        
        $data['ids'] = $ids;
        $data['is_hide_rows'] = false;
        if (isset($action['is_hide_rows'])) {
            $data['is_hide_rows'] = $action['is_hide_rows'];
        }
        
        return response()->json($data);
    } // end handleMultiActionWithOption
    
    protected function handleGetImportTemplate()
    {
        $type = request()->get('type');
        $method = 'do'. ucfirst($type) .'TemplateDownload';
        
        $this->controller->import->$method();
    } // end handleGetImportTemplate
    
    protected function handleImport()
    {
        $file   = request()->file('file');
        $type   = request()->get('type');
        $method = 'doImport'. ucfirst($type);
        
        $res = $this->controller->import->$method($file);
        
        $response = array(
            'status' => $res
        );
        return response()->json($response);
    } // end handleImport
    
    protected function handleExport()
    {
        $type   = request()->get('type');
        $method = 'doExport'. ucfirst($type);
        $idents = array_keys(request()->get('b', array()));
        
        $this->controller->export->$method($idents);
    } // end handleExport

    protected function handleSetPerPage()
    {
        $perPage = request()->get('per_page');
        
        $definitionName = $this->controller->getOption('def_name');
        $sessionPath = 'table_builder.'.$definitionName.'.per_page';
        session()->put($sessionPath, $perPage);
        
        $response = array(
            'status' => true,
        );
        return response()->json($response);
    } // end handleSetPerPage
    
    protected function handleChangeDirection()
    {
        $order = array(
            'direction' => request()->get('direction'),
            'field' => request()->get('field')
        );
        
        $definitionName = $this->controller->getOption('def_name');
        $sessionPath = 'table_builder.'.$definitionName.'.order';
        session()->put($sessionPath, $order);

        $response = array(
            'status' => true,
        );
        return response()->json($response);
    } // end handleChangeDirection
    
    protected function handleUploadFile()
    {
        // FIXME:
        $file = request()->file('file');
        
        if ($this->controller->hasCustomHandlerMethod('onFileUpload')) {
            $res = $this->controller->getCustomHandler()->onFileUpload($file);
            if ($res) {
                return $res;
            }
        }
        
        $extension = $file->getClientOriginalExtension();
        $fileName  = time() .'_'. \Jarboe::urlify($file->getClientOriginalName()) .'.'. $extension;
        
        $definitionName = $this->controller->getOption('def_name');
        $prefixPath = 'storage/tb-'.$definitionName.'/';
        $postfixPath = date('Y') .'/'. date('m') .'/'. date('d') .'/';
        $destinationPath = $prefixPath . $postfixPath;
        
        $status = $file->move($destinationPath, $fileName);
        
        $data = array(
            'status' => $status,
            'link'   => url($destinationPath . $fileName),
            'short_link' => $destinationPath . $fileName,
        );
        return response()->json($data);
    } // end handleUploadFile
    
    protected function handleUploadPhoto()
    {
        // FIXME:
        $ident = request()->get('ident');
        $file  = request()->file('image');
        $num   = request()->get('num');
        
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
        
        return response()->json($data);
    } // end handleUploadPhoto
    
    protected function handleUploadPhotoWysiwyg()
    {
        // FIXME:
        $file = request()->file('image');
        
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
            'link'   => url($destinationPath . $fileName)
        );
        return response()->json($data);
    } // end handleUploadPhotoWysiwyg
    
    protected function handleRedactorImageUpload()
    {
        // FIXME:
        $file = request()->file('file');
        
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
        
        $file->move($destinationPath, $fileName);
        
        $data = array(
            'filelink' => url($destinationPath . $fileName)
        );
        return response()->json($data);
    } // end handleRedactorImageUpload
    
    protected function handleDeleteRow()
    {
        $idRow = $this->getRowID();
        $this->checkEditPermission();

        $result = $this->controller->query->deleteRow($idRow);

        return response()->json($result);
    } // end handleDeleteRow
    
    protected function handleRestoreRow()
    {
        $idRow = $this->getRowID();
        $this->checkEditPermission();

        $result = $this->controller->query->restoreRow($idRow);

        return response()->json($result);
    } // end handleRestoreRow
    
    protected function handleShowAddForm()
    {
        $result = $this->controller->view->showEditForm();

        return response()->json($result);
    } // end handleShowAddForm

    protected function handleSaveAddForm()
    {
        $result = $this->controller->query->insertRow(request()->all());
        $result['html'] = $this->controller->view->getRowHtml($result);

        return response()->json($result);
    } // end handleSaveAddForm

    protected function handleSaveEditForm()
    {
        $this->checkEditPermission();

        $result = $this->controller->query->updateRow(request()->all());
        $result['html'] = $this->controller->view->getRowHtml($result);

        return response()->json($result);
    } // end handleSaveEditForm

    protected function handleShowEditForm()
    {
        $idRow = $this->getRowID();
        $this->checkEditPermission();

        $html = $this->controller->view->showEditForm($idRow);
        $data = array(
            'html' => $html,
            'status' => true
        );

        return response()->json($data);
    } // end handleShowEditForm
    
    protected function handleShowCreateForm()
    {
        $html = $this->controller->view->showEditForm();
        $data = array(
            'html' => $html,
            'status' => true
        );

        return response()->json($data);
    } // end handleShowCreateForm
    
    protected function checkEditPermission()
    {
        if (!$this->controller->isAllowedID($this->getRowID())) {
            throw new \RuntimeException("Permission denied to perform edit for #{$id}.");
        }
    } // end checkEditPermission

    private function getRowID()
    {
        if (request()->has('id')) {
            return request()->get('id');
        }
        throw new \RuntimeException("Undefined row id for action.");
    } // end getRowID

    protected function handleShowList()
    {
        $table = $this->controller->view->showList();
            
        return view('admin::table', compact('table'));
    } // end handleShowList
    
    protected function handleShowEditFormPage($id = false)
    {
        return $this->controller->view->showEditFormPage($id);
    } // end handleShowAddFormPageAction

    protected function handleSearch()
    {
        $this->_prepareSearchFilters();

        return response()->json([
            'status' => true,
        ]);
    } // end handleSearch

    private function _prepareSearchFilters()
    {
        $filters = request()->get('filter', array());

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
        session()->put($sessionPath, $newFilters);
    } // end _prepareSearchFilters
    

}
