'use strict';

var TableBuilder = {

    options: null,
    storage: {},
    admin_prefix: '',
    table: '#widget-grid',
    preloader: '#table-preloader',
    form_preloader: '.form-preloader',
    form: '#modal_form',
    form_edit: '#modal_form_edit',
    export_form: '#tb-export-form',
    form_label: '#modal_form_edit_label',
    form_wrapper: '#modal_wrapper',
    create_form: '#create_form',
    edit_form: '#edit_form',
    filter: '#filters-row :input',

    onDoEdit: null,
    onDoCreate: null,

    init: function(options)
    {
        TableBuilder.options = TableBuilder.getOptions(options);

        TableBuilder.initDoubleClickEditor();
        TableBuilder.initSearchOnEnterPressed();
        //TableBuilder.initImageEditable();
    }, // end init    
    
    initImageEditable: function()
    {TableBuilder.initSeveralImageEditable();return;
        (function (e) {
            "use strict";
            var t = function (e) {
                this.init("image", e, t.defaults)
            };
            e.fn.editableutils.inherit(t, e.fn.editabletypes.abstractinput);
            e.extend(t.prototype, {
                render: function () {
                    this.$input = this.$tpl.find("input")
                },
                value2html: function (t, n) {
                    if (!t) {
                        e(n).empty();
                        return
                    }
                    var r = e("<div>").text(t.tbalt).html() + "" + e("<div>").text(t.tbtitle).html() +
                            "" + e("<div>").text(t.tbident).html();
                    e(n).html(r)
                },
                html2value: function (e) {
                    return null
                },
                value2str: function (e) {
                    var t = "";
                    if (e)
                        for (var n in e)
                            t = t + n + ":" + e[n] + ";";
                    return t
                },
                str2value: function (e) {
                    return e
                },
                value2input: function (e) {
                    if (!e)
                        return;
                    this.$input.filter('[name="tbalt"]').val(e.tbalt);
                    this.$input.filter('[name="tbtitle"]').val(e.tbtitle);
                    this.$input.filter('[name="tbident"]').val(e.tbident);
                },
                input2value: function () {
                    return {
                        tbalt:   this.$input.filter('[name="tbalt"]').val(),
                        tbtitle: this.$input.filter('[name="tbtitle"]').val(),
                        tbident: this.$input.filter('[name="tbident"]').val()
                    };
                },
                activate: function () {
                    this.$input.filter('[name="tbalt"]').focus()
                },
                autosubmit: function () {
                    this.$input.keydown(function (t) {
                        t.which === 13 && e(this).closest("form").submit()
                    })
                }
            });
            t.defaults = e.extend({}, e.fn.editabletypes.abstractinput.defaults, {
                tpl: '<div class="editable-image"><label><span>Alt: </span><input type="text" name="tbalt" class="input-editable"></label></div><div class="editable-image"><label><span>Title: </span><input type="text" name="tbtitle" class="input-editable"></label></div><div><input type="hidden" name="tbident"></div>',
                inputclass: ""
            });
            e.fn.editabletypes.image = t
        })(window.jQuery);
    }, // end initImageEditable
    
    initSeveralImageEditable: function()
    {
        (function (e) {
            "use strict";
            var t = function (e) {
                this.init("image", e, t.defaults)
            };
            e.fn.editableutils.inherit(t, e.fn.editabletypes.abstractinput);
            e.extend(t.prototype, {
                render: function () {
                    this.$input = this.$tpl.find("input")
                },
                value2html: function (t, n) {
                    if (!t) {
                        e(n).empty();
                        return
                    }
                    var r = e("<div>").text(t.tbalt).html() + "" + e("<div>").text(t.tbtitle).html() +
                            "" + e("<div>").text(t.tbident).html() +
                            "" + e("<div>").text(t.tbnum).html();
                    e(n).html(r)
                },
                html2value: function (e) {
                    return null
                },
                value2str: function (e) {
                    var t = "";
                    if (e)
                        for (var n in e)
                            t = t + n + ":" + e[n] + ";";
                    return t
                },
                str2value: function (e) {
                    return e
                },
                value2input: function (e) {
                    if (!e)
                        return;
                    this.$input.filter('[name="tbnum"]').val(e.tbnum);
                    this.$input.filter('[name="tbalt"]').val(e.tbalt);
                    this.$input.filter('[name="tbtitle"]').val(e.tbtitle);
                    this.$input.filter('[name="tbident"]').val(e.tbident);
                },
                input2value: function () {
                    return {
                        tbnum:   this.$input.filter('[name="tbnum"]').val(),
                        tbalt:   this.$input.filter('[name="tbalt"]').val(),
                        tbtitle: this.$input.filter('[name="tbtitle"]').val(),
                        tbident: this.$input.filter('[name="tbident"]').val()
                    };
                },
                activate: function () {
                    this.$input.filter('[name="tbalt"]').focus()
                },
                autosubmit: function () {
                    this.$input.keydown(function (t) {
                        t.which === 13 && e(this).closest("form").submit()
                    })
                }
            });
            t.defaults = e.extend({}, e.fn.editabletypes.abstractinput.defaults, {
                tpl: '<div class="editable-image"><label><span>Alt: </span><input type="text" name="tbalt" class="input-editable"></label></div><div class="editable-image"><label><span>Title: </span><input type="text" name="tbtitle" class="input-editable"></label></div><div><input type="hidden" name="tbident"></div><div><input type="hidden" name="tbnum"></div>',
                inputclass: ""
            });
            e.fn.editabletypes.image = t
        })(window.jQuery);
    }, // end initSeveralImageEditable
    
    initSingleImageEditable: function()
    {
        TableBuilder.initImageEditable();
        //
        var images = jQuery('div.tb-uploaded-image-container img.image-attr-editable, div.tb-uploaded-image-container img.images-attr-editable');
        jQuery.each(images, function(key, img) {
            var $img = jQuery(img);
            $img.editable({
                type: 'image',
                showbuttons: 'bottom',
                url: function(params) {
                    var vals = params.value;
                    
                    // single image doesnt have tbnum
                    if (vals.tbnum === "") {
                        console.log('s');
                        TableBuilder.storage[vals.tbident].alt   = vals.tbalt;
                        TableBuilder.storage[vals.tbident].title = vals.tbtitle;
                    } else {
                        console.log('m');
                        console.log(TableBuilder.storage[vals.tbident]);
                        TableBuilder.storage[vals.tbident][vals.tbnum].alt = vals.tbalt;
                        TableBuilder.storage[vals.tbident][vals.tbnum].title = vals.tbtitle;
                        console.log(TableBuilder.storage[vals.tbident][vals.tbnum]);
                    }
                },
                value: {
                    tbalt:   $img.data('tbalt'),
                    tbtitle: $img.data('tbtitle'),
                    tbident: $img.data('tbident'),
                    tbnum:   $img.data('tbnum')
                },
                display: function (value) {
                    if (!value) {
                        $(this).empty();
                        return;
                    }
                    var html = '<b>' + jQuery('<div>').text(value.tbalt).html() + '</b>, ' 
                             + jQuery('<div>').text(value.tbtitle).html() + '</b>, ' 
                             + jQuery('<div>').text(value.tbident).html() + '</b>, ' 
                             + jQuery('<div>').text(value.tbnum).html();
                    jQuery(this).html(html);
                }
            });
        });
    }, // end initSingleImageEditable
    
    initMultipleImageEditable: function()
    {
        TableBuilder.initSeveralImageEditable();
        //
        var images = jQuery('div.tb-uploaded-image-container img.images-attr-editable');
        jQuery.each(images, function(key, img) {
            var $img = jQuery(img);
            $img.editable({
                type: 'image',
                showbuttons: 'bottom',
                url: function(params) {
                    var vals = params.value;
                    
                    // single image doesnt have tbnum
                    if (vals.tbnum === "") {
                        console.log('s');
                        TableBuilder.storage[vals.tbident].alt   = vals.tbalt;
                        TableBuilder.storage[vals.tbident].title = vals.tbtitle;
                    } else {
                        console.log('m');
                        console.log(TableBuilder.storage[vals.tbident]);
                        TableBuilder.storage[vals.tbident][vals.tbnum].alt = vals.tbalt;
                        TableBuilder.storage[vals.tbident][vals.tbnum].title = vals.tbtitle;
                        console.log(TableBuilder.storage[vals.tbident][vals.tbnum]);
                    }
                },
                value: {
                    tbnum:   $img.data('tbnum'),
                    tbalt:   $img.data('tbalt'),
                    tbtitle: $img.data('tbtitle'),
                    tbident: $img.data('tbident')
                },
                display: function (value) {
                    if (!value) {
                        $(this).empty();
                        return;
                    }
                    var html = '<b>' + jQuery('<div>').text(value.tbalt).html() + '</b>, ' 
                             + jQuery('<div>').text(value.tbtitle).html() + '</b>, ' 
                             + jQuery('<div>').text(value.tbident).html() + '</b>, ' 
                             + jQuery('<div>').text(value.tbnum).html();
                    jQuery(this).html(html);
                }
            });
        });
    }, // end initMultipleImageEditable

    initSearchOnEnterPressed: function()
    {
        jQuery('.filters-row input').keypress(function(event) {
            var keyCode   = event.keyCode ? event.keyCode : event.which;
            var enterCode = '13';

            if (keyCode == enterCode) {
                TableBuilder.search();
            }
        });
    }, // end initSearchOnEnterPressed

    getOptions: function(options) {
        var defaultOptions = {
            lang: {},
            ident: null,
            table_ident: null,
            form_ident: null,
            action_url: null,
            onSearchResponse: null,
            onFastEditResponse: null,
            onShowEditFormResponse: null,
        };

        var options = jQuery.extend(defaultOptions, options);
        TableBuilder.checkOptions(options);

        return options;
    }, // end getOptions

    checkOptions: function(options)
    {
        var requiredOptions = [
            'ident',
            'table_ident',
            'form_ident',
            'action_url'
        ];

        jQuery.each(requiredOptions, function(index, value) {
            if (typeof options[value] === null) {
                alert('TableBuilder: ['+ value +'] is required option.' );
            }
        });
    }, // end checkOptions

    lang: function (ident) {
        if (typeof TableBuilder.options.lang[ident] != "undefined") {
            return TableBuilder.options.lang[ident];
        }

        return ident;
    }, // end lang

    search: function()
    {
        TableBuilder.showProgressBar();

        var $form = jQuery('#'+ TableBuilder.options.table_ident);

        var data = $form.serializeArray();
        data.push({ name: "query_type", value: "search" });

        /* Because serializeArray() ignores unset checkboxes and radio buttons: */
        data = data.concat(
            $form.find('input[type=checkbox]:not(:checked)')
                .map(function() {
                    return {"name": this.name, "value": 0};
                }).get()
        );

        var $posting = jQuery.post(TableBuilder.options.action_url, data);

        $posting.done(function(response) {
            window.location.replace(response.url);
            /*
             TableBuilder.hideProgressBar();

             $form.find('tbody')
             .fadeOut("fast")
             .html(response.tbody)
             .fadeIn("fast");

             $form.find('.tb-pagination')
             .fadeOut("fast")
             .html(response.pagination)
             .fadeIn("fast");

             if (jQuery.isFunction(TableBuilder.options.onSearchResponse)) {
             TableBuilder.options.onSearchResponse(response);
             }
             TableBuilder.initDoubleClickEditor();
             */
        });

    }, // end search

    showProgressBar: function()
    {
        jQuery('#'+TableBuilder.options.ident)
            .find('.ui-overlay').fadeIn();
    }, // end showProgressBar

    hideProgressBar: function()
    {
        jQuery('#'+TableBuilder.options.ident)
            .find('.ui-overlay').fadeOut();
    }, // end hideProgressBar

    initDoubleClickEditor: function()
    {
        jQuery("body").on('click', function() {
            var $editElem = jQuery(".dblclick-edit-opened");
            $editElem.removeClass('dblclick-edit-opened');

            jQuery.each($editElem, function(i, obj) {
                var $editElem = jQuery(obj);
                var $elem = $editElem.find(".dblclick-edit");
                // var previousValue = $elem.attr('previous-value');
                var previousValue = $elem.parent().find('.tb-previous-value').text();

                $elem.html(previousValue);
                $editElem.find(".dblclick-edit-input").val(previousValue);
            });
        });
        jQuery("td").on('click', function(e) {
            e.stopPropagation();
        });

        var $editForm = jQuery('span.dblclick-edit', '#'+TableBuilder.options.table_ident).parent();
        $editForm.dblclick(function() {
            var $elem = jQuery(this).find('span.dblclick-edit');
            var value = $elem.text();

            $elem.parent().addClass('dblclick-edit-opened');
            // $elem.attr('previous-value', value);
            $elem.parent().find('.tb-previous-value').text(value);
        });
    }, // end initDoubleClickEditor

    closeFastEdit: function(context, type, response)
    {
        var $editElem = jQuery(context).parent().parent();
        $editElem.removeClass('dblclick-edit-opened');
        var $elem = $editElem.find(".dblclick-edit");

        if (type == 'cancel') {
            // var previousValue = $elem.attr('previous-value');
            var previousValue = $elem.parent().find('.tb-previous-value').text();
            $elem.html(previousValue);
            $editElem.find(".dblclick-edit-input").val(previousValue);
        } else if (type == 'close') {
            $elem.html(response.value);
        }
    }, // end closeFastEdit

    saveFastEdit: function(context, rowId, rowIdent)
    {
        TableBuilder.showProgressBar();

        var $context = jQuery(context).parent().parent();
        var value = $context.find('.dblclick-edit-input').val();

        var data = [
            {name: "query_type", value: "fast_save"},
            {name: "id", value: rowId},
            {name: "name", value: rowIdent},
            {name: "value", value: value}
        ];


        var $posting = jQuery.post(TableBuilder.options.action_url, data);

        $posting.done(function(response) {
            TableBuilder.hideProgressBar();

            if (jQuery.isFunction(TableBuilder.options.onFastEditResponse)) {
                TableBuilder.options.onFastEditResponse(response);
            }
            TableBuilder.closeFastEdit(context, 'close', response);
        });
    }, // end saveFastEdit

    showEditForm: function(idRow)
    {
        TableBuilder.showProgressBar();

        var data = [
            {name: "query_type", value: "show_edit_form"},
            {name: "id", value: idRow}
        ];
        var $posting = jQuery.post(TableBuilder.options.action_url, data);

        $posting.done(function(response) {
            if (jQuery.isFunction(TableBuilder.options.onShowEditFormResponse)) {
                TableBuilder.options.onShowEditFormResponse(response);
            }
            jQuery('#'+TableBuilder.options.form_ident).html(response);

            jQuery('#'+TableBuilder.options.table_ident)
                .hide("slide", { direction: "left" }, 500)
                .promise()
                .done(function() {
                    jQuery('#'+TableBuilder.options.form_ident)
                        .show("slide", { direction: "right" }, 500)
                        .promise()
                        .done(function() {
                            TableBuilder.hideProgressBar();
                        });
                });
        });
    }, // end showEditForm

    getCreateForm: function()
    {
        TableBuilder.showPreloader();
        TableBuilder.flushStorage();

        //jQuery(TableBuilder.form_label).text('Create');
        jQuery(TableBuilder.form).modal('show');
        TableBuilder.initSummernoteFullscreen();

        TableBuilder.hidePreloader();
    }, // end getCreateForm

    getEditForm: function(id, context)
    {
        TableBuilder.showPreloader();
        TableBuilder.flushStorage();
        jQuery('#wid-id-1').find('tr[data-editing="true"]').removeAttr('data-editing');

        jQuery.ajax({
            type: "POST",
            url: TableBuilder.options.action_url,
            data: { id: id, query_type: "show_edit_form" },
            dataType: 'json',
            success: function(response) {
                console.log('edit form');
//modal_wrapper
                if (response.status) {
                    jQuery(TableBuilder.form_wrapper).html(response.html);

                    //jQuery(TableBuilder.form_label).text('Edit');

                    jQuery(TableBuilder.form_edit).modal('show');
                    jQuery(TableBuilder.form_edit).find('input[data-mask]').each(function() {
                        var $input = jQuery(this);
                        $input.mask($input.attr('data-mask'));
                    });

                    jQuery(context).parent().parent().attr('data-editing', 'true');

                    TableBuilder.initSingleImageEditable();
                    TableBuilder.initMultipleImageEditable();
                    TableBuilder.initSummernoteFullscreen();
                } else {
                    jQuery.smallBox({
                        title : "Что-то пошло не так, попробуйте позже",
                        content : "",
                        color : "#C46A69",
                        iconSmall : "fa fa-times fa-2x fadeInRight animated",
                        timeout : 4000
                    });
                }

                TableBuilder.hidePreloader();
            }
        });
    }, // end getEditForm

    initSummernoteFullscreen: function()
    {
        jQuery('[data-event="fullscreen"]').click(function(){
            jQuery('.modal-dialog').css({width: '100%', margin: '0px'});
        });
    }, // end initSummernoteFullscreen

    closeEditForm: function()
    {
        TableBuilder.showProgressBar();
        jQuery('#'+TableBuilder.options.form_ident)
            .hide("slide", { direction: "left" }, 500)
            .promise()
            .done(function() {
                jQuery('#'+TableBuilder.options.table_ident)
                    .show("slide", { direction: "right" }, 500)
                    .promise()
                    .done(function() {
                        TableBuilder.hideProgressBar();
                    });
            });
    }, // end closeEditForm

    saveEditForm: function()
    {
        TableBuilder.showProgressBar();

        var $form = jQuery('#'+ TableBuilder.options.form_ident);

        var data = $form.serializeArray();
        data.push({ name: "query_type", value: "save_edit_form" });

        /* Because serializeArray() ignores unset checkboxes and radio buttons: */
        data = data.concat(
            $form.find('input[type=checkbox]:not(:checked)')
                .map(function() {
                    return {"name": this.name, "value": 0};
                }).get()
        );

        var $posting = jQuery.post(TableBuilder.options.action_url, data);

        $posting.done(function(response) {
            location.reload();
        });
    }, //saveEditForm

    insert: function()
    {
        TableBuilder.showProgressBar();

        var data = [
            {name: "query_type", value: "show_add_form"}
        ];
        var $posting = jQuery.post(TableBuilder.options.action_url, data);

        $posting.done(function(response) {
            if (jQuery.isFunction(TableBuilder.options.onShowEditFormResponse)) {
                TableBuilder.options.onShowEditFormResponse(response);
            }
            jQuery('#'+TableBuilder.options.form_ident).html(response);

            jQuery('#'+TableBuilder.options.table_ident)
                .hide("slide", { direction: "left" }, 500)
                .promise()
                .done(function() {
                    jQuery('#'+TableBuilder.options.form_ident)
                        .show("slide", { direction: "right" }, 500)
                        .promise()
                        .done(function() {
                            TableBuilder.hideProgressBar();
                        });
                });
        });
    }, // end insert

    saveInsertForm: function()
    {
        TableBuilder.showProgressBar();

        var $form = jQuery('#'+ TableBuilder.options.form_ident);

        var data = $form.serializeArray();
        data.push({ name: "query_type", value: "save_add_form" });

        /* Because serializeArray() ignores unset checkboxes and radio buttons: */
        data = data.concat(
            $form.find('input[type=checkbox]:not(:checked)')
                .map(function() {
                    return {"name": this.name, "value": 0};
                }).get()
        );

        var $posting = jQuery.post(TableBuilder.options.action_url, data);

        $posting.done(function(response) {
            location.reload();
        });
    }, //saveInsertForm

    delete: function(id)
    {
        TableBuilder.showProgressBar();

        if (!confirm("Are you sure?")) {
            TableBuilder.hideProgressBar();
            return;
        }

        var data = [
            {name: "query_type", value: "delete_row"},
            {name: "id", value: id}
        ];
        var $posting = jQuery.post(TableBuilder.options.action_url, data);

        $posting.done(function(response) {
            jQuery('#'+TableBuilder.options.table_ident)
                .find('tr[id-row="'+response.id+'"]')
                .remove()
                .promise()
                .done(function() {
                    TableBuilder.hideProgressBar();
                });
        });
    }, // end delete

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
                    url: TableBuilder.options.action_url,
                    data: { id: id, query_type: "delete_row"},
                    dataType: 'json',
                    success: function(response) {

                        if (response.status) {

                            jQuery.smallBox({
                                title : "Поле удалено успешно",
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

                        TableBuilder.hidePreloader();
                    }
                });

            }

        });
    }, // end doDelete

    doEdit: function(id)
    {
        TableBuilder.showPreloader();
        TableBuilder.showFormPreloader(TableBuilder.form_edit);

        var values = jQuery(TableBuilder.edit_form).serializeArray();
        values.push({ name: 'id', value: id });
        values.push({ name: 'query_type', value: "save_edit_form" });
        
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

        // FIXME:
        if (TableBuilder.onDoEdit) {
            values = TableBuilder.onDoEdit(values);
        }

        /* Because serializeArray() ignores unset checkboxes and radio buttons: */
        values = values.concat(
            jQuery(TableBuilder.edit_form).find('input[type=checkbox]:not(:checked)')
                .map(function() {
                    return {"name": this.name, "value": 0};
                }).get()
        );
console.log(values);
        jQuery.ajax({
            type: "POST",
            url: TableBuilder.options.action_url,
            data: values,
            dataType: 'json',
            success: function(response) {

                TableBuilder.hideFormPreloader(TableBuilder.form_edit);

                if (response.id) {
                    jQuery(TableBuilder.form_edit).modal('hide');

                    jQuery('#wid-id-1').find('tr[data-editing="true"]').replaceWith(response.html);

                    jQuery.smallBox({
                        title : "Поле обновлено успешно",
                        content : "",
                        color : "#659265",
                        iconSmall : "fa fa-check fa-2x fadeInRight animated",
                        timeout : 4000
                    });
                } else {
                    /*
                     jQuery.smallBox({
                     title : response.error, // "Что-то пошло не так, попробуйте позже"
                     content : "",
                     color : "#C46A69",
                     iconSmall : "fa fa-times fa-2x fadeInRight animated",
                     timeout : 4000
                     });
                     */
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

                TableBuilder.hidePreloader();
            }
        });
    }, // end doEdit

    removeInputValues: function(context)
    {
        jQuery(':input', context)
            .removeAttr('checked')
            .removeAttr('selected')
            .not(':button, :submit, :reset, :hidden, :radio, :checkbox')
            .val('');
        jQuery('textarea', context).text('');
        jQuery('div[id$="-wysiwyg"]', context).code('');
    }, // end removeInputValues

    doCreate: function()
    {
        TableBuilder.showPreloader();
        TableBuilder.showFormPreloader(TableBuilder.form);

        var values = jQuery(TableBuilder.create_form).serializeArray();
        values.push({ name: "query_type", value: "save_add_form" });
        
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

        // FIXME:
        if (TableBuilder.onDoCreate) {
            values = TableBuilder.onDoCreate(values);
        }
console.log(values);
        /* Because serializeArray() ignores unset checkboxes and radio buttons: */
        values = values.concat(
            jQuery(TableBuilder.create_form).find('input[type=checkbox]:not(:checked)')
                .map(function() {
                    return {"name": this.name, "value": 0};
                }).get()
        );

        console.log(values);
        jQuery.ajax({
            type: "POST",
            url: TableBuilder.options.action_url,
            data: values,
            dataType: 'json',
            success: function(response) {
                TableBuilder.hideFormPreloader(TableBuilder.form);

                if (response.id) {
                    jQuery('#wid-id-1').find('tbody').prepend(response.html);

                    TableBuilder.removeInputValues(TableBuilder.form);
                    jQuery(TableBuilder.form).modal('hide');

                    jQuery.smallBox({
                        title : "Новое поле создано успешно",
                        content : "",
                        color : "#659265",
                        iconSmall : "fa fa-check fa-2x fadeInRight animated",
                        timeout : 4000
                    });
                } else {
                    jQuery.smallBox({
                        title : "Что-то пошло не так, попробуйте позже",
                        content : "",
                        color : "#C46A69",
                        iconSmall : "fa fa-times fa-2x fadeInRight animated",
                        timeout : 4000
                    });
                }

                TableBuilder.hidePreloader();
            }
        });
    }, // end doCreate

    showPreloader: function()
    {
        jQuery(TableBuilder.preloader).show();
    }, // end showPreloader

    hidePreloader: function()
    {
        jQuery(TableBuilder.preloader).hide();
    }, // end hidePreloader

    showFormPreloader: function(context)
    {
        jQuery(TableBuilder.form_preloader, context).show();
    }, // end showPreloader

    hideFormPreloader: function(context)
    {
        jQuery(TableBuilder.form_preloader, context).hide();
    }, // end hidePreloader

    uploadImage: function(context, ident)
    {
        var data = new FormData();
        data.append("image", context.files[0]);
        data.append('ident', ident);
        data.append('query_type', 'upload_photo');

        jQuery.ajax({
            data: data,
            type: "POST",
            url: TableBuilder.options.action_url,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status) {
                    //jQuery(context).parent().next().val(response.short_link);
                    
                    TableBuilder.storage[ident] = {
                        'alt'  : '',
                        'title': '',
                        'sizes': response.data.sizes
                    };

                    var html = '<img class="image-attr-editable" '+
                         'data-tbalt="" '+
                         'data-tbtitle="" '+
                         'data-tbident="'+ ident +'" '+
                         'height="80px" src="'+ response.link +'" />';
                         
                    // FIXME: too ugly to execute
                    jQuery(context).parent().parent().parent().parent().find('.tb-uploaded-image-container').html(html);
                    
                    TableBuilder.initSingleImageEditable();
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
    }, // end uploadImage 

    uploadMultipleImages: function(context, ident)
    {
        var data = new FormData();
        data.append("image", context.files[0]);
        data.append('ident', ident);
        data.append('query_type', 'upload_photo');
        
        var num = 0;
        if (typeof TableBuilder.storage[ident] !== 'undefined') {
            num = TableBuilder.storage[ident].length;
        }
        console.log(TableBuilder.storage[ident]);
        console.log(num);
        data.append('num', num);

        jQuery.ajax({
            data: data,
            type: "POST",
            url: TableBuilder.options.action_url,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status) {
                    if (!num) {
                        TableBuilder.storage[ident] = [];
                    }
                    TableBuilder.storage[ident].push({
                        'alt'  : '',
                        'title': '',
                        'sizes': response.data.sizes
                    });
console.log(num);
                    var html = '';
                    html += '<li>';
                    html += '<img src="'+ response.link +'" class="images-attr-editable" '+
                                 'data-tbnum="'+ num +'" '+
                                 'data-tbalt="" '+
                                 'data-tbtitle="" '+
                                 'data-tbident="'+ ident +'" />';
                    html += '<div class="tb-btn-delete-wrap">';
                    html +=   '<button class="btn btn-default btn-sm tb-btn-image-delete" '
                    html +=         'type="button" '
                    html +=         "onclick=\"TableBuilder.deleteImage('"+num+"','"+ident+"', this);\">"
                    html +=     '<i class="fa fa-times"></i>'
                    html += '</button>'
                    html += '</div>';
                    html += '</li>';
                    
                    // FIXME: too ugly to execute
                    jQuery(context).parent().parent().parent().parent().find('.tb-uploaded-image-container').children().append(html);
                    
                    TableBuilder.initMultipleImageEditable();
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
    }, // end uploadMultipleImages

    deleteImage: function(num, ident, context)
    {
        var $li = jQuery(context).parent().parent();
        $li.hide();

        // remove deleted image from storage
        TableBuilder.storage[ident][num].remove = true;
    }, // end deleteImage

    uploadImageFromWysiwygSummertime: function(files, editor, $editable)
    {
        if (files.length < 1) {
            return;
        }

        var data = new FormData();
        data.append("image", files[0]);
        data.append('query_type', 'upload_photo_wysiwyg');

        jQuery.ajax({
            data: data,
            type: "POST",
            url: TableBuilder.options.action_url,
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

    doChangeSortingDirection: function(ident, context)
    {
        TableBuilder.showPreloader();

        var $context = jQuery(context);

        var isAscDirection = $context.hasClass('sorting_asc');
        var direction = isAscDirection ? 'desc' : 'asc';

        var vals = [
            {name: "query_type", value: "change_direction"},
            {name: "direction", value: direction},
            {name: "field", value: ident}
        ];

        jQuery.ajax({
            data: vals,
            type: "POST",
            url: TableBuilder.options.action_url,
            cache: false,
            dataType: "json",
            success: function(response) {
                // FIXME:
                window.location.replace(response.url);
            }
        });
    }, // end doChangeSortingDirection


    uploadFile: function(context, ident)
    {
        var data = new FormData();
        data.append("file", context.files[0]);
        data.append('query_type', 'upload_file');
        data.append('ident', ident);

        jQuery.ajax({
            data: data,
            type: "POST",
            url: TableBuilder.options.action_url,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status) {
                    jQuery(context).parent().next().val(response.short_link);

                    var html = '<a href="'+ response.link +'" target="_blank">Скачать</a>';
                    jQuery(context).parent().parent().next().html(html);
                } else {
                    TableBuilder.showErrorNotification("Ошибка при загрузке файла");
                }
            }
        });
    }, // end uploadFile 

    showErrorNotification: function(message)
    {
        jQuery.smallBox({
            title : message,
            content : "",
            color : "#C46A69",
            iconSmall : "fa fa-times fa-2x fadeInRight animated",
            timeout : 4000
        });
    }, // end showErrorNotification

    doEmbedToText: function($summernote)
    {
        jQuery.ajax({
            type: "POST",
            // FIXME: move action url to options
            url: TableBuilder.admin_prefix +'/tb/embed-to-text',
            data: {text: $summernote.code()},
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    console.log(response);
                    $summernote.code('').html(response.html);
                } else {
                    TableBuilder.showErrorNotification('Что-то пошло не так');
                }
            }
        });
    }, // end doEmbedToText
    
    setPerPageAmount: function(perPage)
    {
        TableBuilder.showProgressBar();

        var data = {
            query_type: "set_per_page",
            per_page: perPage
        };

        var $posting = jQuery.post(TableBuilder.options.action_url, data);
        $posting.done(function(response) {
            window.location.replace(response.url);
        });
    }, // end setPerPageAmount
    
    doExport: function(type)
    {
        TableBuilder.showPreloader();
        
        var $iframe = jQuery("#submiter");
        
        var values = jQuery(TableBuilder.export_form).serializeArray();
        values.push({ name: 'type', value: type });
        values.push({ name: 'query_type', value: "export" });
        
        var out = new Array();
        jQuery.each(values, function(index, val) {
            out.push(val['name'] +'='+ val['value']);
        });
        
        var url = document.location.pathname +'?'+ out.join('&');
        
        $iframe.attr('src', url);
        
        TableBuilder.hidePreloader();
    }, // end doExport
    
    flushStorage: function()
    {
        TableBuilder.storage = {};
    }, // end flushStorage

    doImport: function(context, ident)
    {
        TableBuilder.showPreloader();
        
        var data = new FormData();
        data.append("image", context.files[0]);
        data.append('ident', ident);
        data.append('query_type', 'upload_photo');

        jQuery.SmartMessageBox({
            title : "Произвести импорт?",
            content : "Результат импорта нельзя отменить",
            buttons : '[Нет][Да]'
        }, function(ButtonPressed) {
            if (ButtonPressed === "Да") {
                jQuery.smallBox({
                    title : "Callback function",
                    content : "<i class='fa fa-clock-o'></i> <i>You pressed Yes...</i>",
                    color : "#659265",
                    iconSmall : "fa fa-check fa-2x fadeInRight animated",
                    timeout : 4000
                });
            } else {
                TableBuilder.hidePreloader();
            }
        });
        return;
        jQuery.ajax({
            data: data,
            type: "POST",
            url: TableBuilder.options.action_url,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status) {
                } else {
                }
            }
        });
    }, // end doImport
    
    doDownloadImportTemplate: function(type)
    {
        TableBuilder.showPreloader();
        
        var $iframe = jQuery("#submiter");
        
        var values = new Array();
        values.push('type='+ type);
        values.push('query_type=get_import_template');
        
        var url = document.location.pathname +'?'+ values.join('&');
        
        $iframe.attr('src', url);
        
        TableBuilder.hidePreloader();
    }, // end doDownloadImportTemplate
    
};

