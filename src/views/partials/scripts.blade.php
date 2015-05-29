


<!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)-->
<script data-pace-options='{ "restartOnRequestAfter": true }' src="{{asset('packages/yaro/jarboe/js/plugin/pace/pace.min.js')}}"></script>



<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script>
    if (!window.jQuery.ui) {
        document.write('<script src="{{asset('packages/yaro/jarboe/js/libs/jquery-ui-1.10.3.min.js')}}"><\/script>');
    }
</script>   
<!-- JQUERY VALIDATE -->
<script src="{{asset('packages/yaro/jarboe/js/plugin/jquery-validate/jquery.validate.min.js')}}"></script>

<script>
    $(document).ajaxComplete(function(event, xhr, settings) {
        if (xhr.status == 401) {
            $('#locked-screen').show();
            $('.tb-modal:visible').addClass('superbox-modal-hide').hide();
        } else if (xhr.status == 500) {
            var response = $.parseJSON(xhr.responseText);
            $.bigBox({
                title : response.error.type,
                content : '<p style="overflow-y: auto; word-break: break-all; height: 100px;">'+ response.error.message +"<br>@"+ response.error.line +"<br>"+ response.error.file +'</p>',
                color : "#C79121",
                icon : ""
            });
            TableBuilder.hidePreloader();
            TableBuilder.hideFormPreloader();
        }
    });
    
    $('#locked-screen-form').submit(function(event) {
        jQuery.ajax({
            type: "POST",
            url: $('#locked-screen-form').attr('action') +'?is_from_locked_screen=12',
            data: $('#locked-screen-form').serializeArray(),
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    $('#locked-screen').hide();
                    $('#locked-screen-form')[0].reset();
                    
                    TableBuilder.hidePreloader();
                    TableBuilder.hideFormPreloader();
                    TableBuilder.hideFormPreloader(TableBuilder.form_edit);
                    TableBuilder.hideFormPreloader(TableBuilder.form);
                    $('.superbox-modal-hide').removeClass('superbox-modal-hide').show();
                } else {
                    TableBuilder.showErrorNotification(response.error);
                }
            }
        });
        event.preventDefault();
    });
    jQuery("#locked-screen-form").validate({
        // Rules for form validation
        rules : {
            email : {
                required : true,
                email : true
            },
            password : {
                required : true,
                minlength : 3,
                maxlength : 20
            }
        },
        // Messages for form validation
        messages : {
            email : {
                required : '{{trans('jarboe::login.email_required')}}',
                email : '{{trans('jarboe::login.email_valid')}}'
            },
            password : {
                required : '{{trans('jarboe::login.password_required')}}'
            }
        },
        // Do not change code below
        errorPlacement : function(error, element) {
            error.insertAfter(element.parent());
        }
    });
</script>

<script src="{{asset('packages/yaro/jarboe/js/plugin/datepicker/jquery.ui.datepicker-ru.js')}}"></script>

<script type="text/javascript" src="{{asset('packages/yaro/jarboe/js/plugin/datetimepicker/jquery-ui-timepicker-addon.js')}}"></script>
<script type="text/javascript" src="{{asset('packages/yaro/jarboe/js/plugin/datetimepicker/jquery-ui-timepicker-addon-i18n.min.js')}}"></script>
<script type="text/javascript" src="{{asset('packages/yaro/jarboe/js/plugin/datetimepicker/jquery-ui-sliderAccess.js')}}"></script>
<script>
$.timepicker.regional['ru'] = {
    timeOnlyTitle: 'Выберите время',
    timeText: 'Время',
    hourText: 'Часы',
    minuteText: 'Минуты',
    secondText: 'Секунды',
    millisecText: 'Миллисекунды',
    microsecText: 'Микросекунды',
    timezoneText: 'Часовой пояс',
    currentText: 'Сейчас',
    closeText: 'Закрыть',
    timeFormat: 'HH:mm',
    amNames: ['AM', 'A'],
    pmNames: ['PM', 'P'],
    isRTL: false
};
$.timepicker.setDefaults($.timepicker.regional['ru']);
</script>

<script src="{{ asset('packages/yaro/jarboe/js/plugin/superbox/superbox.js') }}"></script>
<script src="{{ asset('packages/yaro/jarboe/superbox.js') }}"></script>

<script src="{{ asset('packages/yaro/jarboe/file_storage.js') }}"></script>

<script src="{{asset('packages/yaro/jarboe/js/app.config.js')}}"></script>
<script src="{{asset('packages/yaro/jarboe/js/app.min.js')}}"></script>


<!-- JS TOUCH : include this plugin for mobile drag / drop touch events
<script src="{{asset('packages/yaro/jarboe/js/plugin/jquery-touch/jquery.ui.touch-punch.min.js')}}"></script> -->

<!-- BOOTSTRAP JS -->
<script src="{{asset('packages/yaro/jarboe/js/bootstrap/bootstrap.min.js')}}"></script>

<!-- CUSTOM NOTIFICATION -->
<script src="{{asset('packages/yaro/jarboe/js/notification/SmartNotification.min.js')}}"></script>

<!-- JARVIS WIDGETS -->
<script src="{{asset('packages/yaro/jarboe/js/smartwidgets/jarvis.widget.min.js')}}"></script>
{{--
<!-- EASY PIE CHARTS -->
<script src="{{asset('packages/yaro/jarboe/js/plugin/easy-pie-chart/jquery.easy-pie-chart.min.js')}}"></script>

<!-- SPARKLINES -->
<script src="{{asset('packages/yaro/jarboe/js/plugin/sparkline/jquery.sparkline.min.js')}}"></script>
--}}


<script src="{{asset('packages/yaro/jarboe/js/plugin/summernote/summernote.min.js')}}"></script>
<script src="{{asset('packages/yaro/jarboe/js/plugin/summernote/lang/summernote-ru-RU.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('packages/yaro/jarboe/css/summernote.css')}}">


<script src="{{asset('packages/yaro/jarboe/js/plugin/redactor/redactor.min.js')}}"></script>
<script src="{{asset('packages/yaro/jarboe/js/plugin/redactor/imagemanager.js')}}"></script>
<script src="{{asset('packages/yaro/jarboe/js/plugin/redactor/table.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('packages/yaro/jarboe/js/plugin/redactor/redactor.css')}}">

<!-- JQUERY MASKED INPUT -->
<script src="{{asset('packages/yaro/jarboe/js/plugin/masked-input/jquery.maskedinput.min.js')}}"></script>

{{--
<script src="{{asset('packages/yaro/jarboe/js/plugin/bootstrap-timepicker/bootstrap-timepicker.min.js')}}"></script>
--}}

<!-- JQUERY SELECT2 INPUT -->
<script src="{{asset('packages/yaro/jarboe/js/plugin/select2/select2.min.js')}}"></script>

{{--
<!-- JQUERY UI + Bootstrap Slider -->
<script src="{{asset('packages/yaro/jarboe/js/plugin/bootstrap-slider/bootstrap-slider.min.js')}}"></script>

<!-- browser msie issue fix -->
<script src="{{asset('packages/yaro/jarboe/js/plugin/msie-fix/jquery.mb.browser.min.js')}}"></script>
--}}
<!-- FastClick: For mobile devices -->
<script src="{{asset('packages/yaro/jarboe/js/plugin/fastclick/fastclick.js')}}"></script>

<!--[if IE 7]>

<h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>

<![endif]-->

<!-- Demo purpose only -->
{{--
<script src="{{asset('packages/yaro/jarboe/js/demo.js')}}"></script>

<!-- MAIN APP JS FILE -->
<script src="{{asset('packages/yaro/jarboe/js/app.js')}}"></script>
--}}

<!-- PAGE RELATED PLUGIN(S) -->
<script src="{{asset('packages/yaro/jarboe/js/plugin/colorpicker/bootstrap-colorpicker.min.js')}}"></script>
<script src="{{asset('packages/yaro/jarboe/js/plugin/datatables/jquery.dataTables-cust.min.js')}}"></script>
<script src="{{asset('packages/yaro/jarboe/js/plugin/datatables/ColReorder.min.js')}}"></script>
<script src="{{asset('packages/yaro/jarboe/js/plugin/datatables/FixedColumns.min.js')}}"></script>
<script src="{{asset('packages/yaro/jarboe/js/plugin/datatables/ColVis.min.js')}}"></script>
<script src="{{asset('packages/yaro/jarboe/js/plugin/datatables/ZeroClipboard.js')}}"></script>
<script src="{{asset('packages/yaro/jarboe/js/plugin/datatables/media/js/TableTools.min.js')}}"></script>
<script src="{{asset('packages/yaro/jarboe/js/plugin/datatables/DT_bootstrap.js')}}"></script>
<script src="{{asset('packages/yaro/jarboe/js/plugin/jquery-nestable/jquery.nestable.min.js')}}"></script>
<script src="{{asset('packages/yaro/jarboe/js/plugin/x-editable/moment.min.js')}}"></script>
<script src="{{asset('packages/yaro/jarboe/js/plugin/x-editable/x-editable.min.js')}}"></script>
{{--
<script src="{{asset('packages/yaro/jarboe/js/table.js')}}"></script>
--}}
<script type="text/javascript">

// DO NOT REMOVE : GLOBAL FUNCTIONS!

$(document).ready(function() {
    
    pageSetUp();
    
    /*
     * BASIC
     */
    // $('#dt_basic').dataTable({
    //     "sPaginationType" : "bootstrap_full"
    // });

    /* END BASIC */

    /* Add the events etc before DataTables hides a column 
    $("#datatable_fixed_column thead input").keyup(function() {
        oTable.fnFilter(this.value, oTable.oApi._fnVisibleToColumnIndex(oTable.fnSettings(), $("thead input").index(this)));
    });*/

    // $("#datatable_fixed_column thead input").each(function(i) {
    //     this.initVal = this.value;
    // });
    // $("#datatable_fixed_column thead input").focus(function() {
    //     if (this.className == "search_init") {
    //         this.className = "";
    //         this.value = "";
    //     }
    // });
    // $("#datatable_fixed_column thead input").blur(function(i) {
    //     if (this.value == "") {
    //         this.className = "search_init";
    //         this.value = this.initVal;
    //     }
    // });     
    

    // var oTable = $('#datatable_fixed_column').dataTable({
    //     "sDom" : "<'dt-top-row'><'dt-wrapper't><'dt-row dt-bottom-row'<'row'<'col-sm-6'i><'col-sm-6 text-right'p>>",
    //     //"sDom" : "t<'row dt-wrapper'<'col-sm-6'i><'dt-row dt-bottom-row'<'row'<'col-sm-6'i><'col-sm-6 text-right'>>",
    //     "oLanguage" : {
    //         "sSearch" : "Search all columns:"
    //     },
    //     "bSortCellsTop" : true
    // });     
    


    /*
     * COL ORDER
     */
    // $('#datatable_col_reorder').dataTable({
    //     "sPaginationType" : "bootstrap",
    //     "sDom" : "R<'dt-top-row'Clf>r<'dt-wrapper't><'dt-row dt-bottom-row'<'row'<'col-sm-6'i><'col-sm-6 text-right'p>>",
    //     "fnInitComplete" : function(oSettings, json) {
    //         $('.ColVis_Button').addClass('btn btn-default btn-sm').html('Columns <i class="icon-arrow-down"></i>');
    //     }
    // });
    
    /* END COL ORDER */

    /* TABLE TOOLS */
    // $('#datatable_tabletools').dataTable({
    //     "sDom" : "<'dt-top-row'Tlf>r<'dt-wrapper't><'dt-row dt-bottom-row'<'row'<'col-sm-6'i><'col-sm-6 text-right'p>>",
    //     "oTableTools" : {
    //         "aButtons" : ["copy", "print", {
    //             "sExtends" : "collection",
    //             "sButtonText" : 'Save <span class="caret" />',
    //             "aButtons" : ["csv", "xls", "pdf"]
    //         }],
    //         "sSwfPath" : "js/plugin/datatables/media/swf/copy_csv_xls_pdf.swf"
    //     },
    //     "fnInitComplete" : function(oSettings, json) {
    //         $(this).closest('#dt_table_tools_wrapper').find('.DTTT.btn-group').addClass('table_tools_group').children('a.btn').each(function() {
    //             $(this).addClass('btn-sm btn-default');
    //         });
    //     }
    // });

/* END TABLE TOOLS */

        


});

</script>


<style type="text/css">

</style>

<script type="text/javascript">
    TBMenu.admin_uri = '{{\Config::get('jarboe::admin.uri')}}';
</script>