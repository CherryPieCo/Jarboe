<?php 

namespace Yaro\Jarboe;

use Input;
use View;
use Response;
use Config;
use URL;


class TreeCatalogController 
{
    protected $model;
    protected $options;
    
    
    public function __construct($model, array $options)
    {
        $this->model   = $model;
        $this->options = $options;
    } // end __construct
    
    // FIXME:
    public function setOptions(array $options = array())
    {
        $this->options = $options;
    } // end setOptions

    public function handle()
    {
        switch (request()->get('__structure_query_type')) {
            
            case 'do_create_node':
                return $this->doCreateNode();
            
            case 'do_change_active_status':
                return $this->doChangeActiveStatus();
                
            case 'do_change_position':
                return $this->doChangePosition();
            
            case 'do_delete_node':
                return $this->doDeleteNode();
                
            case 'do_edit_node':
                return $this->doEditNode();
                                
            case 'do_update_node':
                return $this->doUpdateNode();
                
            case 'get_edit_modal_form':
                return $this->getEditModalForm();
                
            default:
                return $this->handleShowCatalog();
        }
    } // end handle
    
    public function doUpdateNode()
    {
        $model = $this->model;
        
        switch (request()->get('name')) {
            case 'template':
                $node = $model::find(request()->get('pk'));
                $node->template = request()->get('value');
                $node->save();
                break;
            
            default:
                throw new \RuntimeException('someone tries to hack me :c');
        }
        
        $model::flushCache();
    } // end doUpdateNode
        
    public function doCreateNode()
    {
        $model = $this->model;
        $root = $model::find(request()->get('node', 1));
        
        $node = new $model();
        $activeField = $node->getNodeActiveField();
        $options = $node->getNodeActiveFieldOptions();
        
        $node->parent_id = request()->get('node', 1);
        $node->title     = request()->get('title');
        $node->template  = request()->get('template');
        $node->$activeField = $options ? '' : '0';
        $node->save();
        
        $node->slug = request()->get('slug') ?: request()->get('title');
        $node->save();
        
        $node->makeChildOf($root);
        
        $model::rebuild();
        $model::flushCache();
        
        return response()->json(array(
            'status' => true, 
            'id' => $node->id,
            // FIXME: will not work with table definition
            // FIXME: render tree template too
            'table_html' => view('admin::tree.content')
                                ->with('current', $node->parent()->first())
                                ->render(),
        ));
    } // end doCreateNode
    
    public function doChangeActiveStatus()
    {
        $model = $this->model;
        
        $node = $model::find(request()->get('id'));
        
        $activeField = $node->getNodeActiveField();
        $options = $node->getNodeActiveFieldOptions();
        
        $value = request()->get('is_active');
        if ($options) {
            $value = implode(array_filter(array_keys(request()->get('onoffswitch', array()))), ',');
        }
        $node->$activeField = $value;
        
        $node->save();
        
        $model::flushCache();
        
        return response()->json(array(
            'active' => true
        ));
    } // end doChangeActiveStatus
    
    public function doChangePosition()
    {
        $model = $this->model;
        
        $id = request()->get('id');
        $idParent = request()->get('parent_id', 1);
        $idLeftSibling  = request()->get('left_sibling_id');
        $idRightSibling = request()->get('right_sibling_id');
        
        $item = $model::find($id);
        $root = $model::find($idParent);
        
        $prevParentID = $item->parent_id;
        $item->makeChildOf($root);
        
        $item->slug = $item->slug;
        $item->save();
        
        if ($prevParentID == $idParent) {
            if ($idLeftSibling) {
                $item->moveToRightOf($model::find($idLeftSibling));
            } elseif ($idRightSibling) {
                $item->moveToLeftOf($model::find($idRightSibling));
            }
        }
        
        $model::rebuild();
        $model::flushCache();

        $item = $model::find($item->id);
        
        return response()->json([
            'status' => true, 
            'item' => $item, 
            'parent_id' => $root->id
        ]);
    } // end doChangePosition
    
    // FIXME: fix me, fix
    public function process()
    {
        $model = $this->model;
        
        $idNode  = request()->get('__node', request()->get('node', 1));
        $current = $model::find($idNode);

        $templates = $model::getTemplates();
        $template = config('jarboe.c.structure.default');
        if (isset($templates[$current->template])) {
            $template = $templates[$current->template];
        }
        
        $options = [
            'url' => URL::current(),
            'additional' => [
                'node'    => $idNode,
                'current' => $current,
            ]
        ];
        $definition = $template['node_definition'];
        if ($template['type'] == 'table') {
            $definition = $template['definition'];
        }
        
        return \Jarboe::table($definition, $options);
    } // end process
    
    public function doDeleteNode()
    {
        $model = $this->model;
        
        $status = $model::destroy(request()->get('id'));
        $model::flushCache();
        
        return response()->json([
            'status' => $status
        ]);   
    } // end doDeleteNode
    
    private function handleShowCatalog()
    {
        \Jarboe::addAsset('js', 'packages/yaro/jarboe/js/plugin/x-editable/moment.min.js');
        \Jarboe::addAsset('js', 'packages/yaro/jarboe/js/plugin/x-editable/x-editable.min.js');
        
        $model = $this->model;
        
        $tree = $model::all()->toHierarchy();
        
        $idNode  = request()->get('node', 1);
        $current = $model::find($idNode);

        $parentIDs = array();
        foreach ($current->getAncestors() as $anc) {
            $parentIDs[] = $anc->id;
        }

        $templates = $model::getTemplates();
        $template = config('jarboe.c.structure.default');
        if (isset($templates[$current->template])) {
            $template = $templates[$current->template];
        }
        
        if ($template['type'] == 'table') {
            // HACK: get table template from view object
            $tableView = \Jarboe::table($template['definition'], [
                'url' => URL::current(),
                'additional' => [
                    'node'    => $idNode,
                    'current' => $current,
                ],
            ]);
            $table = $tableView->table;
            $content = view('admin::tree.content', compact('current', 'table', 'template'));
        } elseif (false && $current->isLeaf()) {
            $content = 'ama leaf';
        } else {
            $content = view('admin::tree.content', compact('current', 'template'));
        }
        
        return view('admin::tree', compact('tree', 'content', 'current', 'parentIDs'));
    } // end handleShowCatalog
    
    public function getEditModalForm()
    {
        $model = $this->model;
        
        $idNode = request()->get('id');
        $current = $model::find($idNode);
        $templates = $model::getTemplates();
        $template = config('jarboe.c.structure.default');
        if (isset($templates[$current->template])) {
            $template = $templates[$current->template];
        }
        
        $options = array(
            'url'      => URL::current(),
            'additional' => array(
                'node'    => $idNode,
                'current' => $current,
            )
        );
        $controller = new JarboeController($template['node_definition'], $options);
        
        $html = $controller->view->showEditForm($idNode, true);
        
        return response()->json(array(
            'status' => true,
            'html' => $html
        ));
    } // end getEditModalForm
    
    public function doEditNode()
    {
        $model = $this->model;
        
        $idNode    = request()->get('id');
        $item      = $model::find($idNode);
        $templates = $model::getTemplates();
        $template  = config('jarboe.c.structure.default');
        if (isset($templates[$item->template])) {
            $template = $templates[$item->template];
        }

        $options = [
            'url' => URL::current(),
            'additional' => [
                'node'    => $idNode,
                'current' => $item,
            ],
        ];
        $controller = new JarboeController($template['node_definition'], $options);
        
        
        $result = $controller->query->updateRow(request()->all());
        $model::flushCache();
        
        $current = $item->parent()->first();
        $data = compact('item', 'current');
        $result['html'] = view('admin::tree.content_row', $data)->render();

        return response()->json($result);   
    } // end doEditNode

}
    