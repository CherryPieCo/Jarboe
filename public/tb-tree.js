'use strict';

var Tree = 
{
    admin_prefix: '',
    parent_id: 99999,
    
    init: function()
    {
        $('#tb-tree').jstree({
            "core" : {
              //"check_callback" : true,
              'check_callback': function(operation, node, node_parent, node_position, more) {
                    // operation can be 'create_node', 'rename_node', 'delete_node', 'move_node' or 'copy_node'
                    // in case of 'rename_node' node_position is filled with the new node name

                    if (operation === "move_node") {
                        //console.log(node_parent);
                        return node_parent.id !== "#"; //only allow dropping inside nodes of type 'Parent'
                    }
                    return true;  //allow all other operations
                }
            },
            "dnd": {
                check_while_dragging: true
            },
            "plugins" : [ "dnd" ]
        }).bind("move_node.jstree", function (e, data) {
           //console.log(data);
           //console.log($('#'+data.node.id).prev());
           
           var $current = jQuery('#'+data.node.id);
           jQuery.ajax({
                url: Tree.admin_prefix +'/tb/tree/change-pos',
                type: 'POST',
                dataType: 'json',
                cache: false,
                data: { 
                    id:               $current.data('id'), 
                    parent_id:        jQuery('#'+data.parent).data('id'),
                    left_sibling_id:  $current.prev().data('id'), 
                    right_sibling_id: $current.next().data('id')
                },
                success: function(response) {
                    if (response.status) {
                        $current.data('parent-id', response.parent_id);
                    }
                }
            });
        });
        
        
        //Tree.initNestable();
        //Tree.initInnerNestable();
        Tree.initResizableTable();
    }, // end saveMenuPreference
    
    initResizableTable: function()
    {
        $("#tb-tree-table").resizableColumns({
            store: window.store
        });
    }, // end initResizableTable
    
    initNestable: function()
    {
        jQuery('#tb-tree').nestable({
            maxDepth: 20,
            onDragFinished  : function(currentNode, parentNode) {
                jQuery.ajax({
                    url: Tree.admin_prefix +'/tb/tree/change-pos',
                    type: 'POST',
                    dataType: 'json',
                    cache: false,
                    data: { 
                        id:               jQuery(currentNode).data('id'), 
                        parent_id:        jQuery(parentNode).data('id'),
                        left_sibling_id:  jQuery(currentNode).prev().data('id'), 
                        right_sibling_id: jQuery(currentNode).next().data('id')
                    },
                    success: function(response) {
                        if (response.status) {
                            jQuery(currentNode).data('parent-id', response.parent_id);
                        }
                    }
                });
            }
        });
        //jQuery('#nestable3').nestable('collapseAll');
    }, // end initNestable
        
    initInnerNestable: function()
    {
        jQuery('#inner-nested').nestable({
            maxDepth: 0,
            onDragFinished  : function(currentNode, parentNode) {
                jQuery.ajax({
                    url: Tree.admin_prefix +'/tb/tree/change-pos',
                    type: 'POST',
                    dataType: 'json',
                    cache: false,
                    data: { 
                        id:               jQuery(currentNode).data('id'), 
                        parent_id:        jQuery(parentNode).data('id') ? jQuery(parentNode).data('id') : Tree.parent_id,
                        left_sibling_id:  jQuery(currentNode).prev().data('id'), 
                        right_sibling_id: jQuery(currentNode).next().data('id')
                    },
                    success: function(response) {
                        if (response.status) {
                            jQuery(currentNode).data('parent-id', response.parent_id);
                        }
                    }
                });
            }
        });
        //jQuery('#nestable3').nestable('collapseAll');
    }, // end initInnerNestable
    
    
    toggleCollapse: function(context)
    {
        if ($(context).hasClass('expanded')) {
            $('#tb-tree').nestable('collapseAll');
            $(context).removeClass('expanded');
        } else {
            $('#tb-tree').nestable('expandAll');
            $(context).addClass('expanded');
        }
    }, // end 
    
};


//
jQuery(document).ready(function(){
    Tree.init();
});
