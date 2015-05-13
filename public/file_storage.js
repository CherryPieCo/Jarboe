'use strict';

var FileStorage = 
{

    input: null,

    init: function()
    {
        //
    }, // end init
    
    
    uploadFile: function(context)
    {
        var $titleInput = $(context).parent().parent().find('.j-image-title');
        
        var data = new FormData();
        for (var x = 0; x < context.files.length; x++) {
            data.append("files[]", context.files[x]);
        }
        data.append('query_type', 'file_storage');
        data.append('storage_type', 'upload_file');
        data.append('title', $titleInput.val());
        data.append('__node', TableBuilder.getUrlParameter('node'));
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
                    $('.j-files-table').prepend(response.html);
                } else {
                    TableBuilder.showErrorNotification("Ошибка при загрузке файла");
                }
            }
        });
    }, // end uploadFile
    
    deleteFile: function(context, idFile)
    {
        jQuery.SmartMessageBox({
            title : "Удалить файл?",
            content : "Эту операцию нельзя будет отменить.",
            buttons : '[Нет][Да]'
        }, function(ButtonPressed) {
            if (ButtonPressed === "Да") {
                jQuery.ajax({
                    type: "POST",
                    url: TableBuilder.getActionUrl(),
                    data: { query_type: 'file_storage', storage_type: 'delete_file', id: idFile, '__node': TableBuilder.getUrlParameter('node') },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status) {
                            jQuery(context).parent().parent().remove();
                            TableBuilder.showSuccessNotification('Файл удален');
                        } else {
                            TableBuilder.showErrorNotification('Что-то пошло не так');
                        }
                    }
                });
            }
        });
    }, // end deleteFile
    
    selectFile: function(context, idFile)
    {
        FileStorage.input.val(idFile);
        TableBuilder.closeImageStorageModal();
    }, // end selectImage
    
};

$(document).ready(function() {
    //FileStorage.init();
});
