'use strict';

var Superbox = 
{

    input: null,

    fields: {
        image: {},
        gallery: {},
        tag: {},
        storage: {},
    },

    init: function()
    {
        $('.superbox').SuperBox();
    }, // end init
    
    openCatalog: function(id) 
    {
    }, // end openCatalog
    
    deleteTag: function(id, context)
    {
        // TODO:
        $(context).hide();
    }, // end deleteTag
    
    deleteImage: function(context)
    {
        jQuery.SmartMessageBox({
            title : "Удалить изображение?",
            content : "Эту операцию нельзя будет отменить.",
            buttons : '[Нет][Да]'
        }, function(ButtonPressed) {
            if (ButtonPressed === "Да") {
                jQuery.ajax({
                    type: "POST",
                    url: TableBuilder.getActionUrl(),
                    data: { query_type: 'image_storage', storage_type: 'delete_image', id: $(context).data('id') },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status) {
                            $('.superbox .superbox-show', '.b-j-images').remove();
                            $('.superbox .superbox-list.active', '.b-j-images').remove();
                            
                            Superbox.init();
                            TableBuilder.showSuccessNotification('Изображение удалено');
                        } else {
                            TableBuilder.showErrorNotification('Что-то пошло не так');
                        }
                    }
                });
            }
        });
    }, // end deleteImage
    
    uploadImage: function(context)
    {
        var $titleInput = $(context).parent().parent().find('.j-image-title');
        var data = new FormData();
        data.append("image", context.files[0]);
        data.append('query_type', 'image_storage');
        data.append('storage_type', 'upload_image');
        data.append('title', $titleInput.val());
        // FIXME: catalog
        data.append('id_catalog', 1);

        jQuery.ajax({
            data: data,
            type: "POST",
            url: TableBuilder.getActionUrl(),
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response);
                if (response.status) {
                    $titleInput.val('');
                    $('.superbox').prepend(response.html);
                    Superbox.init();
                } else {
                    TableBuilder.showErrorNotification("Ошибка при загрузке изображения");
                }
            }
        });
    }, // end uploadFile
    
    saveImageInfo: function(context)
    {
        var $context = $(context);
        var data = $context.parent().parent().find('form').serializeArray();
        data.push({ name: 'id', value: $context.data('id') });
        data.push({ name: 'query_type', value: 'image_storage' });
        data.push({ name: 'storage_type', value: 'save_image_info' });
        
        jQuery.ajax({
            type: "POST",
            url: TableBuilder.getActionUrl(),
            data: data,
            dataType: 'json',
            success: function(response) {
            console.log(response);
                if (response.status) {
                    $('.superbox .superbox-list.active .superbox-img', '.b-j-images').data('info', JSON.stringify(response.info).replace(/"/g, '~'));
                    TableBuilder.showSuccessNotification('Сохранено');
                } else {
                    TableBuilder.showErrorNotification('Что-то пошло не так');
                }
            }
        });
        
        console.table(data);
    }, // end saveImageInfo
    
    selectImage: function(context)
    {
        var value = '[|image::'+ $('.superbox .superbox-list.active .superbox-img', '.b-j-images').data('id') +'|]';
        
        Superbox.input.val(value);
        TableBuilder.closeImageStorageModal();
    }, // end selectImage
    
    showGalleries: function(context)
    {
        var $context = $(context);
        if ($context.hasClass('active')) {
            return;
        }
        
        $('.b-j-galleries').show();
        $('.b-j-images').hide();
        $('.b-j-tags').hide();
        
        $context.parent().find('.active').removeClass('active');
        $context.addClass('active');
    }, // end showGalleries
    
    showImages: function(context)
    {
        var $context = $(context);
        if ($context.hasClass('active')) {
            return;
        }
        
        $('.b-j-galleries').hide();
        $('.b-j-images').show();
        $('.b-j-tags').hide();
        
        $context.parent().find('.active').removeClass('active');
        $context.addClass('active');
    }, // end showImages
    
    showTags: function(context)
    {
        var $context = $(context);
        if ($context.hasClass('active')) {
            return;
        }
        
        $('.b-j-galleries').hide();
        $('.b-j-images').hide();
        $('.b-j-tags').show();
        
        $context.parent().find('.active').removeClass('active');
        $context.addClass('active');
    }, // end showTags
    
};

$(document).ready(function() {
    //Superbox.init();
});
