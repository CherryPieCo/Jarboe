'use strict';

var Table = 
{
    admin_prefix: null,
    table: '#widget-grid',
    preloader: '#table-preloader',
    form_preloader: '.form-preloader',
    form: '#modal_form',
    form_edit: '#modal_form_edit',
    form_label: '#modal_form_edit_label',
    form_wrapper: '#modal_wrapper',
    create_form: '#create_form',
    edit_form: '#edit_form',
    filter: '#filters-row :input',

    init: function()
    {
    }, // end init

    doDelete: function(id, context)
    {
        jQuery.SmartMessageBox({
            title : "Delete row?",
            content : "This action can not be undone.",
            buttons : '[No][Yes]'
        }, function(ButtonPressed) {
            if (ButtonPressed === "Yes") {
                Table.showPreloader();

                jQuery.ajax({
                    type: "POST",
                    url: window.location.origin + window.location.pathname +'/remove',
                    data: { id: id },
                    dataType: 'json',
                    success: function(response) {

                        if (response.status) {

                            jQuery.smallBox({
                                title : "Row has been deleted successfully",
                                content : "",
                                color : "#659265",
                                iconSmall : "fa fa-check fa-2x fadeInRight animated",
                                timeout : 4000
                            });

                            jQuery(context).parent().parent().remove();
                        } else {
                            jQuery.smallBox({
                                title : "Something went wrong, try again later",
                                content : "",
                                color : "#C46A69",
                                iconSmall : "fa fa-times fa-2x fadeInRight animated",
                                timeout : 4000
                            });
                        }

                        Table.hidePreloader();
                    }
                });

            }

        });
    }, // end doDelete


    doEdit: function(id)
    {
        Table.showPreloader();
        Table.showFormPreloader(Table.form_edit);

        var values = jQuery(Table.edit_form).serializeArray();
        values.push({ name: 'id', value: id });

        jQuery.ajax({
            type: "POST",
            url: window.location.origin + window.location.pathname +'/edit',
            data: values,
            dataType: 'json',
            success: function(response) {

                Table.hideFormPreloader(Table.form_edit);

                if (response.status) {
                    jQuery(Table.form_edit).modal('hide');

                    jQuery('#wid-id-1').find('tr[data-editing="true"]').replaceWith(response.html);

                    jQuery.smallBox({
                        title : "Row has been updated successfully",
                        content : "",
                        color : "#659265",
                        iconSmall : "fa fa-check fa-2x fadeInRight animated",
                        timeout : 4000
                    });
                } else {
                    jQuery.smallBox({
                        title : "Something went wrong, try again later",
                        content : "",
                        color : "#C46A69",
                        iconSmall : "fa fa-times fa-2x fadeInRight animated",
                        timeout : 4000
                    });
                }

                Table.hidePreloader();
            }
        });
    }, // end doEdit

    doCreate: function()
    {
        Table.showPreloader();
        Table.showFormPreloader(Table.form);

        jQuery.ajax({
            type: "POST",
            url: window.location.origin + window.location.pathname +'/create',
            data: jQuery(Table.create_form).serializeArray(),
            dataType: 'json',
            success: function(response) {
                Table.hideFormPreloader(Table.form);

                if (response.status) {
                    jQuery('#wid-id-1').find('tbody').prepend(response.html);

                    Table.removeInputValues(Table.form);
                    jQuery(Table.form).modal('hide');

                    jQuery.smallBox({
                        title : "Row has been created successfully",
                        content : "",
                        color : "#659265",
                        iconSmall : "fa fa-check fa-2x fadeInRight animated",
                        timeout : 4000
                    });
                } else {
                    jQuery.smallBox({
                        title : "Something went wrong, try again later",
                        content : "",
                        color : "#C46A69",
                        iconSmall : "fa fa-times fa-2x fadeInRight animated",
                        timeout : 4000
                    });
                }

                Table.hidePreloader();
            }
        });
    }, // end doCreate

    doFilter: function()
    {
        Table.showPreloader();

        jQuery.ajax({
            type: "POST",
            url: window.location.origin + window.location.pathname, // +'/filter'
            data: jQuery(Table.filter).serializeArray(),
            dataType: 'json',
            success: function(response) {

                if (response.status) {
                    jQuery(Table.table).replaceWith(response.html);
                } else {
                    jQuery.smallBox({
                        title : "Something went wrong, try again later",
                        content : "",
                        color : "#C46A69",
                        iconSmall : "fa fa-times fa-2x fadeInRight animated",
                        timeout : 4000
                    });
                }

                Table.hidePreloader();
            }
        });
    }, // end doFilter

    removeInputValues: function(context)
    {
        jQuery(':input', context)
            .removeAttr('checked')
            .removeAttr('selected')
            .not(':button, :submit, :reset, :hidden, :radio, :checkbox')
            .val('');
    }, // end removeInputValues

    getEditForm: function(id, context)
    {
        Table.showPreloader();
        jQuery('#wid-id-1').find('tr[data-editing="true"]').removeAttr('data-editing');

        jQuery.ajax({
            type: "POST",
            url: window.location.origin + window.location.pathname +'/get-form',
            data: { id: id },
            dataType: 'json',
            success: function(response) {

                if (response.status) {
                    jQuery(Table.form_wrapper).html(response.html);

                    jQuery(Table.form_label).text('Edit');
                    jQuery(Table.form_edit).modal('show');

                    jQuery(context).parent().parent().attr('data-editing', 'true');
                } else {

                }

                Table.hidePreloader();
            }
        });


    }, // end getEditForm

    getCreateForm: function()
    {
        Table.showPreloader();

        jQuery(Table.form_label).text('Create');
        jQuery(Table.form).modal('show');

        Table.hidePreloader();
    }, // end getCreateForm

    showPreloader: function()
    {
        jQuery(Table.preloader).show();
    }, // end showPreloader

    hidePreloader: function()
    {
        jQuery(Table.preloader).hide();
    }, // end hidePreloader

    showFormPreloader: function(context)
    {
        jQuery(Table.form_preloader, context).show();
    }, // end showPreloader

    hideFormPreloader: function(context)
    {
        jQuery(Table.form_preloader, context).hide();
    }, // end hidePreloader


    
};


//
jQuery(document).ready(function() {
    Table.init();
});