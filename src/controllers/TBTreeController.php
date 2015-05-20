<?php 

namespace Yaro\Jarboe;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Config;


class TBTreeController extends \Controller
{

    public function showTree()
    {
        $tree = Tree::all()->toHierarchy();
        
        $idNode  = Input::get('node', 1);
        $current = Tree::find($idNode);

        $parentIDs = array();
        foreach ($current->getAncestors() as $anc) {
            $parentIDs[] = $anc->id;
        }

        $templates = Config::get('jarboe::tree.templates');
        $template = Config::get('jarboe::tree.default');
        if (isset($templates[$current->template])) {
            $template = $templates[$current->template];
        }
        
        if ($template['type'] == 'table') {
            $options = array(
                'url'      => \URL::current(),
                'def_name' => 'tree.'. $template['definition'],
                'additional' => array(
                    'node' => $idNode
                )
            );
            list($table, $form) = \Jarboe::table($options);
            $content = View::make('admin::tree.content', compact('current', 'table', 'form', 'template'));
        } elseif (false && $current->isLeaf()) {
            $content = 'ama leaf';
        } else {
            $content = View::make('admin::tree.content', compact('current', 'template'));
        }
        
        return View::make('admin::tree', compact('tree', 'content', 'current', 'parentIDs'));
    } // end showTree
    
    public function getEditModalForm()
    {
        $idNode = Input::get('id');
        $current = Tree::find($idNode);
        $templates = Config::get('jarboe::tree.templates');
        $template = Config::get('jarboe::tree.default');
        if (isset($templates[$current->template])) {
            $template = $templates[$current->template];
        }
        
        $options = array(
            'url'      => \URL::current(),
            'def_name' => 'tree.'. $template['node_definition'],
            'additional' => array(
                'node' => $idNode
            )
        );
        $controller = new JarboeController($options);
        
        $html = $controller->view->showEditForm($idNode, true);
        
        return Response::json(array(
            'status' => true,
            'html' => $html
        ));
    } // end getEditModalForm
    
    public function doEditNode()
    {
        $idNode = Input::get('id');
        $current = Tree::find($idNode);
        $templates = Config::get('jarboe::tree.templates');
        $template = Config::get('jarboe::tree.default');
        if (isset($templates[$current->template])) {
            $template = $templates[$current->template];
        }
        
        $options = array(
            'url'      => \URL::current(),
            'def_name' => 'tree.'. $template['definition'],
            'additional' => array(
                'node' => $idNode
            )
        );
        $controller = new JarboeController($options);
        
        
        $result = $controller->query->updateRow(Input::all());
        $item = Tree::find($idNode);
        $result['html'] = View::make('admin::tree.content_row', compact('item'))->render();

        $this->doFlushTreeStructureCache();

        return Response::json($result);   
    } // end doEditNode
    
    public function doDeleteNode()
    {
        $item = Tree::find(Input::get('id'));
        $status = $item->delete();
        
        
        $this->doFlushTreeStructureCache();
        
        return Response::json(array(
            'status' => $status
        ));   
    } // end doDeleteNode

    public function handleTree()
    {
        $idNode  = Input::get('node', 1);
        $current = Tree::find($idNode);

        $templates = Config::get('jarboe::tree.templates');
        $template = Config::get('jarboe::tree.default');
        if (isset($templates[$current->template])) {
            $template = $templates[$current->template];
        }
        
        if ($template['type'] == 'table') {
            $options = array(
                'url'      => \URL::current(),
                'def_name' => 'tree.'. $template['definition'],
                'additional' => array(
                    'node' => $idNode
                )
            );
            return \Jarboe::table($options);
        }

        //
    } // end handleTree
    
    public function changePosition()
    {
        $id = Input::get('id');
        $idParent = Input::get('parent_id', 1);
        $idLeftSibling  = Input::get('left_sibling_id');
        $idRightSibling = Input::get('right_sibling_id');
        
        $item = Tree::find($id);
        $root = Tree::find($idParent);
        
        $prevParentID = $item->parent_id;
        $item->makeChildOf($root);
        
        $item->slug = $item->slug;
        $item->save();
        
        if ($prevParentID == $idParent) {
            if ($idLeftSibling) {
                $item->moveToRightOf(Tree::find($idLeftSibling));
            } elseif ($idRightSibling) {
                $item->moveToLeftOf(Tree::find($idRightSibling));
            }
        }
        
        Tree::rebuild();
        
        $this->doFlushTreeStructureCache();

        $item = Tree::find($item->id);
        
        $data = array(
            'status' => true, 
            'item' => $item, 
            'parent_id' => $root->id
        );
        return Response::json($data);
    } // end changePosition
    
    private function doFlushTreeStructureCache()
    {
        \Cache::tags('j_tree')->flush();
    } // end doFlushTreeStructureCache

    public function changeActive()
    {
        $activeField = \Config::get('jarboe::tree.node_active_field.field');
        $options = \Config::get('jarboe::tree.node_active_field.options', array());
        
        $value = Input::get('is_active');
        if ($options) {
            $value = implode(array_filter(Input::get('onoffswitch', array())), ',');
        }
        
        DB::table('tb_tree')->where('id', Input::get('id'))->update(array(
            $activeField => $value
        ));
        
        $this->doFlushTreeStructureCache();
    } // end changeActive
    
    public function doCreateNode()
    {
        $root = Tree::find(Input::get('node', 1));
        
        $node = new Tree();
        $node->parent_id = Input::get('node', 1);
        $node->title     = Input::get('title');
        $node->slug      = Input::get('slug') ? : Input::get('title');
        $node->template  = Input::get('template');
        $node->is_active = '0';
        $node->save();
        
        $node->makeChildOf($root);
        
        Tree::rebuild();
        
        $this->doFlushTreeStructureCache();
        
        return Response::json(array(
            'status' => true, 
        ));
    } // end doCreateNode
    
    public function doUpdateNode()
    {
        switch (Input::get('name')) {
            case 'template':
                DB::table('tb_tree')->where('id', Input::get('pk'))->update(array(
                    'template' => Input::get('value')
                ));
                break;
            
            default:
                throw new \RuntimeException('someone tries to hack me :c');
        }
        
        $this->doFlushTreeStructureCache();
    } // end doUpdateNode

}