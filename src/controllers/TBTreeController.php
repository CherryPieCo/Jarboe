<?php 

namespace Yaro\TableBuilder;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;


class TBTreeController extends \Controller
{

    public function showTree()
    {
        // FIXME: amke root catalog first
        $tree = Tree::all()->toHierarchy();
        
        $idNode  = Input::get('node');
        $current = $tree['99999'];
        if ($idNode) {
            $current = Tree::find($idNode);
        }
        
        $options = array(
            'url'      => \URL::current(),
            'def_name' => 'settings',
        );
        list($table, $form) = \TableBuilder::create($options);
        $content = View::make('admin::tree.content', compact('current', 'table', 'form'));
        
        
        return View::make('admin::tree', compact('tree', 'content', 'current'));
    } // end showTree
    
    public function changePosition()
    {
        $id = Input::get('id');
        $idParent = Input::get('parent_id', null);
        $idLeftSibling  = Input::get('left_sibling_id', null);
        $idRightSibling = Input::get('right_sibling_id', null);
        
        $item = Tree::find($id);
        
        $idRoot = null;
        $depth  = null;
        if ($idParent) {
            $root = Tree::find($idParent);
            $prevParentID = $item->parent_id;
            $item->makeChildOf($root);
            
            $idRoot = $root->id;
            $depth = $root->depth + 1;
            
            if ($prevParentID == $idParent) {
                if ($idLeftSibling) {
                    $item->moveToRightOf(Tree::find($idLeftSibling));
                } elseif ($idRightSibling) {
                    $item->moveToLeftOf(Tree::find($idRightSibling));
                }
            }
        } else {
            $idRoot = 99999;
            $root = Tree::find($idRoot);
            $item->makeChildOf($root);
            
            if ($idLeftSibling) {
                //$item->moveToRightOf(Tree::find($idLeftSibling));
            } elseif ($idRightSibling) {
                //$item->moveToLeftOf(Tree::find($idRightSibling));
            }
            //$item->makeRoot();
        }
        
        
        
        Tree::rebuild();

        $item = Tree::find($item->id);
        
        $data = array(
            'status' => true, 
            'item' => $item, 
            'depth' => $depth, 
            'parent_id' => $idRoot
        );
        return Response::json($data);
    } // end changePosition

}