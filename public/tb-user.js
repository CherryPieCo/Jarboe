'use strict';

var TBUser = 
{
    
    admin_uri: '',
    groupRequiredFields: 1,
    id_user: null,
    stored_image: new FormData(),
    
    init: function()
    {
    }, // end init
    
    storeImage: function(file)
    {
        TBUser.stored_image.append("image", file);
    }, // end storeImage

    uploadImage: function(id, file)
    {
        var data = new FormData();
        data.append("image", file);
        data.append('id', id);
        
        jQuery.ajax({
            data: data,
            type: "POST",
            url: TBUser.admin_uri + '/tb/users/upload-image/',
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status) {
                    jQuery('#tbu-avatar').attr('src', response.link);
                    jQuery('#tbu-image-input').val(response.short_link);
                } else {
                    console.log(':c');
                }
            }
        });
    }, // end uploadImage
    
    doRemoveUser: function(context, id)
    {
        jQuery.SmartMessageBox({
            title : "Удалить?",
            content : "Эту операцию нельзя будет отменить.",
            buttons : '[Нет][Да]'
        }, function(ButtonPressed) {
            if (ButtonPressed === "Да") {
                jQuery.ajax({
                    type: "POST",
                    url: TBUser.admin_uri + '/tb/users/delete',
                    data: { id: id },
                    dataType: 'json',
                    success: function(response) {

                        if (response.status) {
                            jQuery.smallBox({
                                title : "Пользователь удален успешно",
                                content : "",
                                color : "#659265",
                                iconSmall : "fa fa-check fa-2x fadeInRight animated",
                                timeout : 4000
                            });

                            jQuery(context).parent().parent().remove();
                        } else {
                            jQuery.smallBox({
                                title : "Что-то пошло не так, попробуйте позже",
                                content : "",
                                color : "#C46A69",
                                iconSmall : "fa fa-times fa-2x fadeInRight animated",
                                timeout : 4000
                            });
                        }
                    }
                });
            }
        });
    }, // end removeUser

    deleteImage: function()
    {
        jQuery('#tbu-avatar').attr('src', '/packages/yaro/table-builder/img/blank_avatar.gif');
        jQuery('#tbu-image-input').val('');
    }, // end deleteImage
    
    doEdit: function(id)
    {
        var values = jQuery('#user-update-form').serializeArray();
        values.push({ name: 'id', value: id });
        
        jQuery.ajax({
            type: "POST",
            url: TBUser.admin_uri + '/tb/users/update',
            data: values,
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    jQuery.smallBox({
                        title : "Карточка пользователя успешно обновлена",
                        content : "",
                        color : "#659265",
                        iconSmall : "fa fa-check fa-2x fadeInRight animated",
                        timeout : 4000
                    });
                } else {
                    var errors = '';
                    jQuery(response.errors).each(function(key, val) {
                        errors += val +'<br>';
                    });
                    
                    jQuery.bigBox({
                        //title : "Big Information box",
                        content : errors,
                        color : "#C46A69",
                        //timeout: 6000,
                        icon : "fa fa-warning shake animated",
                        //number : "1",
                    });
                }
            }
        });
    }, // end doEdit    
    
    doCreate: function()
    {
        var data = TBUser.stored_image;
        var values = jQuery('#user-create-form').serializeArray();
        jQuery.each(values, function(index, obj) {
            data.append(obj.name, obj.value);
        });
        
        jQuery.ajax({
            type: "POST",
            url: TBUser.admin_uri + '/tb/users/do-create',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status) {
                    jQuery.smallBox({
                        title : "Карточка пользователя успешно создана",
                        content : "",
                        color : "#659265",
                        iconSmall : "fa fa-check fa-2x fadeInRight animated",
                        timeout : 4000
                    });
                    
                    setTimeout(function() { 
                        window.location.href = TBUser.admin_uri + '/tb/users/'+ response.id;
                    }, 2000);
                } else {
                    var errors = '';
                    jQuery(response.errors).each(function(key, val) {
                        errors += val +'<br>';
                    });
                    
                    jQuery.bigBox({
                        //title : "Big Information box",
                        content : errors,
                        color : "#C46A69",
                        //timeout: 6000,
                        icon : "fa fa-warning shake animated",
                        //number : "1",
                    });
                }
            }
        });
        return false;
    }, // end doCreate
    
    doCreateGroup: function()
    {
        var values = jQuery('#group-create-form').serializeArray();
        if (values.length != TBUser.groupRequiredFields) {
            jQuery.bigBox({
                content : 'Необходимо заполнить все поля',
                color : "#C46A69",
                timeout: 6000,
                icon : "fa fa-warning shake animated",
            });
            return false;
        }
        
        jQuery.ajax({
            type: "POST",
            url: TBUser.admin_uri + '/tb/groups/do-create',
            data: values,
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    jQuery.smallBox({
                        title : "Группа успешно создана",
                        content : "",
                        color : "#659265",
                        iconSmall : "fa fa-check fa-2x fadeInRight animated",
                        timeout : 4000
                    });
                    
                    setTimeout(function() { 
                        window.location.href = TBUser.admin_uri + '/tb/groups/'+ response.id;
                    }, 2000);
                } else {
                    var errors = '';
                    jQuery(response.errors).each(function(key, val) {
                        errors += val +'<br>';
                    });
                    
                    jQuery.bigBox({
                        //title : "Big Information box",
                        content : errors,
                        color : "#C46A69",
                        //timeout: 6000,
                        icon : "fa fa-warning shake animated",
                        //number : "1",
                    });
                }
            }
        });
        return false;
    }, // end doCreateGroup    
    
    doEditGroup: function(id)
    {
        var values = jQuery('#group-edit-form').serializeArray();
        if (values.length != TBUser.groupRequiredFields) {
            jQuery.bigBox({
                content : 'Необходимо заполнить все поля',
                color : "#C46A69",
                timeout: 6000,
                icon : "fa fa-warning shake animated",
            });
            return false;
        }
        
        values.push({ name: 'id', value: id });
        
        jQuery.ajax({
            type: "POST",
            url: TBUser.admin_uri + '/tb/groups/update',
            data: values,
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    jQuery.smallBox({
                        title : "Группа успешно обновлена",
                        content : "",
                        color : "#659265",
                        iconSmall : "fa fa-check fa-2x fadeInRight animated",
                        timeout : 4000
                    });
                } else {
                    var errors = '';
                    jQuery(response.errors).each(function(key, val) {
                        errors += val +'<br>';
                    });
                    
                    jQuery.bigBox({
                        content : errors,
                        color : "#C46A69",
                        icon : "fa fa-warning shake animated",
                    });
                }
            }
        });
        return false;
    }, // end doEditGroup
    
};


//
jQuery(document).ready(function(){
    TBUser.init();
});
