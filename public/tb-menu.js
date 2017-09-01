'use strict';

var TBMenu = 
{
    admin_uri: '',
    
    saveMenuPreference: function(option)
    {
        jQuery.ajax({
            type: "POST",
            url: TBMenu.admin_uri + '/tb/menu/collapse',
            data: { option: option },
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                } else {
                    /*
                    jQuery.smallBox({
                        title : "Что-то пошло не так, попробуйте позже",
                        content : "",
                        color : "#C46A69",
                        iconSmall : "fa fa-times fa-2x fadeInRight animated",
                        timeout : 4000
                    });
                    */
                }
            }
        });
    }, // end saveMenuPreference
    
};


//
jQuery(document).ready(function(){
    //TBMenu.init();
});
