'use strict';

var Tree = 
{
    admin_prefix: '',
    parent_id: 1,
    node: 1,
    tree_height: '',
    permissions: {},
    
    setdbl: function() {
        return false;
        $(".jstree-anchor").on('dblclick', function(){ 
            $(".jstree-anchor").unbind('dblclick');
            Tree.setdbl();
            console.log(this);
            window.location.href = window.location.origin + window.location.pathname + '?node='+ $(this).parent().data('id');
        });
    }, // end 
    
    init: function()
    {
        Tree.initModalCallbacks();
        
        
        $('#tb-tree').on('after_open.jstree', function (e, data) {
            Tree.setdbl();
        }).jstree({
            open_parents: true,
            "core" : {
                expand_selected_onload: true,
                dblclick_toggle: true,
                check_callback: function(operation, node, node_parent, node_position, more) {
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
            "contextmenu": {
                "items": function ($node) {
                   var items = {
                        "Open": {
                            "label": "Открыть",
                            "action": function (obj) {
                                window.location.href = window.location.origin + window.location.pathname + '?node='+ $(obj.reference[0].parentElement).data('id');
                            },
                            "separator_after" : true
                        },
                        "Create": {
                            "label": "Добавить",
                            "action": function (obj) {
                                Tree.showCreateForm($(obj.reference[0].parentElement).data('id'));
                            }
                        },
                        "Rename": {
                            "label": "Редактировать",
                            "action": function (obj) {
                                Tree.showEditForm($(obj.reference[0].parentElement).data('id'));
                            }
                        },
                        "Delete": {
                            "label": "Удалить",
                            "icon" : "https://cdn1.iconfinder.com/data/icons/nuove/32x32/actions/fileclose.png",
                            "action": function (obj) {
                                var id = $(obj.reference[0].parentElement).data('id');
                                if (id == 1) {
                                    alert('Дропнуть полсайта? Ниет.');
                                    return;
                                }
                                var $btn = $('.node-del-'+ id);
                                Tree.doDelete(id, $btn);
                                
                                $(obj.reference[0].parentElement).remove();
                            },
                            "separator_before" : true
                        }
                    };
                    
                    if (!Tree.permissions.create) {
                        delete items.Create;
                    }
                    return items;
                }
            },
            "plugins" : [ "dnd", "search", "contextmenu" ]
        }).bind("move_node.jstree", function(e, data) {
           var $current = jQuery('#'+data.node.id);
           jQuery.ajax({
                url: window.location.href,
                type: 'POST',
                dataType: 'json',
                cache: false,
                data: { 
                    id:               $current.data('id'), 
                    parent_id:        jQuery('#'+data.parent).data('id'),
                    left_sibling_id:  $current.prev().data('id'), 
                    right_sibling_id: $current.next().data('id'),
                    __structure_query_type:       'do_change_position'
                },
                success: function(response) {
                    if (response.status) {
                        $current.data('parent-id', response.parent_id);
                        Tree.setdbl();
                    }
                }
            });
        }).bind("select_node.jstree", function (e, data) { 
            //this binding lets
            //us open all parents of the selected node
            //console.log(data);
            /*
            if (typeof data.rslt !== 'undefined') {
                data.rslt.obj.parents('.jstree-closed').each(function() {
                    data.inst.open_node(this);
                });
            }
            */
        }).bind("dblclick.jstree", function (event) {
            var node = $(event.target).closest("li");
            window.location.href = window.location.origin + window.location.pathname + '?node='+ node.context.parentElement.dataset.id;
        });;

        var to = false;
        $('#plugins4_q').keyup(function () {
            if(to) { clearTimeout(to); }
            to = setTimeout(function () {
                var v = $('#plugins4_q').val();
                $('#tb-tree').jstree(true).search(v);
            }, 250);
        });
        Tree.setdbl();
        
        $("#fff").find('div[role="content"]').resizable({
            handles: 'n, s',
            stop: function(event, ui) {
                jQuery.ajax({
                    data: { height: ui.size.height },
                    type: "POST",
                    url: Tree.admin_prefix +'/tb/structure/save/height',
                    dataType: 'json',
                    success: function(response) {
                        if (response.status) {
                        } else {
                            TableBuilder.showErrorNotification("Ошибка");
                        }
                    }
                });
            },
            create: function(event, ui) {
                console.log(Tree.tree_height);
                if (Tree.tree_height) {
                    $("#fff").find('div[role="content"]').css('height', Tree.tree_height);
                    console.log(Tree.tree_height);
                }
            }
        });
        
        
    }, // end init

    activeToggle: function(id, isActive)
    {
        isActive = isActive ? 1 : 0;
        jQuery.ajax({
            url: window.location.href,
            type: 'POST',
            dataType: 'json',
            cache: false,
            data: { 
                id: id,
                is_active: isActive,
                __structure_query_type: 'do_change_active_status'
            },
            success: function(response) {
            }
        });
    }, // end activeToggle
    
    activeSetToggle: function(context, id)
    {
        var $table = $(context).closest('table');
        var $smoke = $table.parent().find('.node-active-smoke-lol');
        $smoke.show();
        
        var data = $table.find(':input').serializeArray();
        data.push({ name: 'id', value: id });
        data.push({ name: '__structure_query_type', value: 'do_change_active_status' });
        
        console.table(data);
        
        jQuery.ajax({
            url: window.location.href,
            type: 'POST',
            dataType: 'json',
            cache: false,
            data: data,
            success: function(response) {
                $smoke.hide();
            }
        });
    }, // end activeSetToggle
    
    showCreateForm: function(id)
    {
        $('#cf-node', '#tree-create-modal').val(id);
        $('#tree-create-modal').modal('show');
    }, // end showCreateForm
    
    initModalCallbacks: function()
    {
        $('#tree-create-modal').on('hidden.bs.modal', function() {
            $('#cf-node').val('');
            $("#tree-create-modal-form")[0].reset();
        });
    }, // end initModalCallbacks
    
    doCreateNode: function()
    {
        var data = $('#tree-create-modal-form').serializeArray();
        data.push({ name: '__structure_query_type', value: 'do_create_node' });
        
        jQuery.ajax({
            url: window.location.href,
            type: 'POST',
            dataType: 'json',
            cache: false,
            data: data,
            success: function(response) {
                if (response.status) {
                    // FIXME:
                    window.location.reload();
                } else {
                    TableBuilder.showErrorNotification('Что-то пошло не так');
                }
            }
        });
    }, // end doCreateNode
    
    showEditForm: function(id)
    {
        TableBuilder.showPreloader();
        
        jQuery.ajax({
            url: window.location.href,
            type: 'POST',
            dataType: 'json',
            cache: false,
            data: { id: id, __structure_query_type: 'get_edit_modal_form' },
            success: function(response) {
                if (response.status) {
                    
                    console.log(response);
                    
                    jQuery(TableBuilder.form_wrapper).html(response.html);


                    jQuery(TableBuilder.form_edit).modal('show');
                    jQuery(TableBuilder.form_edit).find('input[data-mask]').each(function() {
                        var $input = jQuery(this);
                        $input.mask($input.attr('data-mask'));
                    });


                    TableBuilder.initSummernoteFullscreen();
                    TableBuilder.initSelect2Hider();
                    
                } else {
                    TableBuilder.showErrorNotification('Что-то пошло не так');
                }
                
                TableBuilder.hidePreloader();
            }
        });
    }, // end showEditForm
    
    doEdit: function(id)
    {
        TableBuilder.showPreloader();
        TableBuilder.showFormPreloader(TableBuilder.form_edit);

        var values = jQuery(TableBuilder.edit_form).serializeArray();
        values.push({ name: 'id', value: id });
        values.push({ name: '__structure_query_type', value: "do_edit_node" });

        // take values from temp storage (for images)
        jQuery.each(values, function(index, val) {
            if (typeof TableBuilder.storage[val.name] !== 'undefined') {
                var json = JSON.stringify(TableBuilder.storage[val.name]);
                values[index] = {
                    name:  val.name,
                    value: json
                };
            }
        });

        /* Because serializeArray() ignores unset checkboxes and radio buttons: */
        values = values.concat(
            jQuery(TableBuilder.edit_form).find('input[type=checkbox]:not(:checked)')
                .map(function() {
                    return { "name": this.name, "value": 0 };
                }).get()
        );
        var selectMultiple = [];
        jQuery(TableBuilder.edit_form).find('select[multiple="multiple"]').each(function(i, value) {
            if (!$(this).val()) {
                selectMultiple.push({"name": this.name, "value": ''});
            }
        })
        console.table(selectMultiple);
        values = values.concat(selectMultiple);
        console.table(values);
        
        jQuery.ajax({
            type: "POST",
            url: window.location.href,
            data: values,
            dataType: 'json',
            success: function(response) {

                TableBuilder.hideFormPreloader(TableBuilder.form_edit);

                if (response.id) {
                    TableBuilder.showSuccessNotification("Поле обновлено успешно");
                    
                    jQuery(TableBuilder.form_edit).modal('hide');

                    jQuery('.tb-tree-content-inner').find('tr[data-id="'+ id +'"]').replaceWith(response.html);

                } else {
                    var errors = '';
                    jQuery(response.errors).each(function(key, val) {
                        errors += val +'<br>';
                    });
                    TableBuilder.showBigErrorNotification(errors);
                }

                TableBuilder.hidePreloader();
            }
        });
    }, // end doEdit
    
    doDelete: function(id, context)
    {
        jQuery.SmartMessageBox({
            title : "Удалить?",
            content : "Эту операцию нельзя будет отменить.",
            buttons : '[Нет][Да]'
        }, function(ButtonPressed) {
            if (ButtonPressed === "Да") {
                TableBuilder.showPreloader();

                jQuery.ajax({
                    type: "POST",
                    url: window.location.href,
                    data: { id: id, __structure_query_type: 'do_delete_node' },
                    dataType: 'json',
                    success: function(response) {

                        if (response.status) {
                            TableBuilder.showSuccessNotification('Поле удалено успешно');

                            jQuery(context).parent().parent().remove();
                        } else {
                            TableBuilder.showErrorNotification('Что-то пошло не так, попробуйте позже');
                        }

                        TableBuilder.hidePreloader();
                    }
                });

            }

        });
    }, // end doDelete
    
};


//
jQuery(document).ready(function(){
    Tree.init();
});
