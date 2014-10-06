'use strict';

var CatalogBuilder = 
{
    segment: 'catalog',
    
    init: function()
    {
        CatalogBuilder.initNestable();
        CatalogBuilder.initAddNew();
    }, // end init
    
    initNestable: function()
    {
        jQuery('#nestable3').nestable({
            onDragFinished  : function(currentNode, parentNode) {
                jQuery.ajax({
                    url: '/admin/'+ CatalogBuilder.segment +'/change',
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
    
    deleteNestableNode: function(context, id)
    {
        jQuery.SmartMessageBox({
            title : "Удалить?",
            content : "Действие нельзя будет отменить",
            buttons : "[Нет][Да]"
        }, function(buttonPress) {
            if (buttonPress == "Да") {
                jQuery.ajax({
                    url: '/admin/'+ CatalogBuilder.segment +'/delete',
                    type: 'POST',
                    dataType: 'json',
                    cache: false,
                    data: { id: id },
                    success: function(response) {
                        console.log(response);
                        jQuery(context).parent().parent().parent().hide();
                        
                        if (response.status) {
                            jQuery.smallBox({
                                title : "Опция каталога удалена",
                                content : "",
                                color : "#659265",
                                iconSmall : "fa fa-check fa-2x fadeInRight animated"
                            });
                        } else {
                            jQuery.smallBox({
                                title : "Что-то пошло не так, попробуйте позже",
                                content : "",
                                color : "#C46A69",
                                iconSmall : "fa fa-times fa-2x fadeInRight animated"
                            });
                        }
                        
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    }
                });
            }
        });
    }, // end deleteNestableNode
    
    initAddNew: function()
    {
        jQuery('#catalog-add-form').validate({
            // Rules for form validation
            rules : {
                title : {
                    required : true
                },
                slug : {
                    required : true
                }
            },

            // Messages for form validation
            messages : {
                title : {
                    required : 'Название обязательное поле',
                },
                slug : {
                    required : 'Слаг обязательное поле',
                }
            },

            // Ajax form submition
            submitHandler : function(form) {
                
                var values = jQuery(form).serializeArray();
                
                jQuery.ajax({
                    url: '/admin/'+ CatalogBuilder.segment +'/add',
                    type: 'POST',
                    dataType: 'json',
                    cache: false,
                    data: values,
                    success: function(response) {
                        if (response.status) {
                            jQuery.smallBox({
                                title : "Опция каталога создана",
                                content : "",
                                color : "#659265",
                                iconSmall : "fa fa-check fa-2x fadeInRight animated"
                            });
                        } else {
                            jQuery.smallBox({
                                title : "Что-то пошло не так, попробуйте позже",
                                content : "",
                                color : "#C46A69",
                                iconSmall : "fa fa-times fa-2x fadeInRight animated"
                            });
                        }
                        
                        setTimeout(function(){
                            location.reload();
                        }, 2000);
                    }
                });
            },

            // Do not change code below
            errorPlacement : function(error, element) {
                error.insertAfter(element.parent());
            }
        });
    }, // end initAddNew
    
    getEditFormModal: function(context, id, title, slug)
    {
        jQuery('#edit-title').val(title);
        jQuery('#edit-slug').val(slug);
        jQuery('#edit-id').val(id);
        
        jQuery.ajax({
            url: '/admin/'+ CatalogBuilder.segment +'/get-edit-modal',
            type: 'POST',
            dataType: 'json',
            cache: false,
            data: { id: id },
            success: function(response) {
                if (response.status) {
                    jQuery('#editCatalogModal').html(response.html);
                    CatalogBuilder.initEditCatalogRow();
                    jQuery('#editCatalogModal').modal();
                }
            }
        });
        
    }, // end getEditFormModal
    
    initEditCatalogRow: function()
    {
        var $validator = jQuery('#catalog-edit-form').validate({
            // Rules for form validation
            rules : {
                'e-title' : {
                    required : true
                },
                'e-slug' : {
                    required : true
                }
            },

            // Messages for form validation
            messages : {
                'e-title' : {
                    required : 'Название обязательное поле',
                },
                'e-slug' : {
                    required : 'Слаг обязательное поле',
                }
            },

            // Ajax form submition
            submitHandler : function(form) {
                
                var values = jQuery(form).serializeArray();
                
                jQuery.ajax({
                    url: '/admin/'+ CatalogBuilder.segment +'/edit',
                    type: 'POST',
                    dataType: 'json',
                    cache: false,
                    data: values,
                    success: function(response) {
                        if (response.status) {
                            jQuery.smallBox({
                                title : "Опция каталога обновлена",
                                content : "",
                                color : "#659265",
                                iconSmall : "fa fa-check fa-2x fadeInRight animated"
                            });
                        } else {
                            jQuery.smallBox({
                                title : "Что-то пошло не так, попробуйте позже",
                                content : "",
                                color : "#C46A69",
                                iconSmall : "fa fa-times fa-2x fadeInRight animated"
                            });
                        }
                        
                        jQuery('#editCatalogModal').modal('hide');
                    }
                });
            },

            // Do not change code below
            errorPlacement : function(error, element) {
                error.insertAfter(element.parent());
            }
        });
        
        $validator.resetForm();
        jQuery('label.state-error').removeClass('state-error');
        jQuery('label.state-success').removeClass('state-success');
    }, // end initEditCatalogRow
    
    uploadImageFromWysiwygSummertime: function(files, editor, $editable)
    {
        if (files.length < 1) {
            return;
        }
        
        var data = new FormData();
        data.append("image", files[0]);
        
        jQuery.ajax({
            data: data,
            type: "POST",
            url: '/admin/'+ CatalogBuilder.segment +'/upload-image',
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status) {
                    editor.insertImage($editable, response.link);
                } else {
                    jQuery.smallBox({
                        title : "Ошибка при загрузке изображения",
                        content : "",
                        color : "#C46A69",
                        iconSmall : "fa fa-times fa-2x fadeInRight animated",
                        timeout : 4000
                    });
                }
            }
        });
    }, // end uploadImageFromWysiwygSummertime
    
    uploadMultipleImages: function(context, delimiter)
    {
        var data = new FormData();
        data.append("image", context.files[0]);
        
        jQuery.ajax({
            data: data,
            type: "POST",
            url: '/admin/'+ CatalogBuilder.segment +'/upload-image',
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status) {
                    var $input = jQuery(context).parent().next();
                    var value = $input.val();
                    
                    if (!!value) {
                        value += delimiter + response.short_link;
                    } else {
                        value = response.short_link;
                    }
                    $input.val(value);
                    
                    var html = '';
                    html += '<li>';
                    html += '<img src="'+ response.link +'" />';
                    html += '<div class="tb-btn-delete-wrap">';
                    html +=   '<button class="btn btn-default btn-sm tb-btn-image-delete" '
                    html +=         'type="button" '
                    html +=         "onclick=\"CatalogBuilder.deleteImage('"+encodeURIComponent(response.short_link)+"','"+delimiter+"', this);\">"       
                    html +=     '<i class="fa fa-times"></i>'
                    html += '</button>'
                    html += '</div>';
                    html += '</li>';
                    
                    jQuery(context).parent().parent().next().children().append(html);
                } else {
                    jQuery.smallBox({
                        title : "Ошибка при загрузке изображения",
                        content : "",
                        color : "#C46A69",
                        iconSmall : "fa fa-times fa-2x fadeInRight animated",
                        timeout : 4000
                    });
                }
            }
        });
    } , // end uploadMultipleImages
    
    deleteImage: function(link, delimiter, context)
    {
        // XXX: 
        var $li = jQuery(context).parent().parent();
        $li.hide();
        
        var $section = $li.parent().parent().parent();
        var input = $section.children().children()[1];
        var $input = jQuery(input);
        var values = $input.val();console.log(values);
        
        var arr = values.split(',');console.log(arr);
        
        var index = jQuery.inArray(decodeURIComponent(link), arr);console.log(decodeURIComponent(link));
        if (~index) {
            arr.splice(index, 1);
        }
        var newValue = arr.join(delimiter);console.log(newValue);
        $input.val(newValue);
    }, // end deleteImage
    
    translate: function(context, from, to)
    {
        
    }, // end translate
    
};

jQuery(document).ready(function(){
    CatalogBuilder.init();
});
