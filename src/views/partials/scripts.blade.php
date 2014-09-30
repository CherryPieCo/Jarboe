


<!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)-->
<script data-pace-options='{ "restartOnRequestAfter": true }' src="{{asset('packages/yaro/table-builder/js/plugin/pace/pace.min.js')}}"></script>



<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script>
    if (!window.jQuery.ui) {
        document.write('<script src="{{asset('packages/yaro/table-builder/js/libs/jquery-ui-1.10.3.min.js')}}"><\/script>');
    }
</script>

<script src="{{asset('packages/yaro/table-builder/js/app.config.js')}}"></script>
<script src="{{asset('packages/yaro/table-builder/js/app.min.js')}}"></script>


<!-- JS TOUCH : include this plugin for mobile drag / drop touch events
<script src="{{asset('packages/yaro/table-builder/js/plugin/jquery-touch/jquery.ui.touch-punch.min.js')}}"></script> -->

<!-- BOOTSTRAP JS -->
<script src="{{asset('packages/yaro/table-builder/js/bootstrap/bootstrap.min.js')}}"></script>

<!-- CUSTOM NOTIFICATION -->
<script src="{{asset('packages/yaro/table-builder/js/notification/SmartNotification.min.js')}}"></script>

<!-- JARVIS WIDGETS -->
<script src="{{asset('packages/yaro/table-builder/js/smartwidgets/jarvis.widget.min.js')}}"></script>
{{--
<!-- EASY PIE CHARTS -->
<script src="{{asset('packages/yaro/table-builder/js/plugin/easy-pie-chart/jquery.easy-pie-chart.min.js')}}"></script>

<!-- SPARKLINES -->
<script src="{{asset('packages/yaro/table-builder/js/plugin/sparkline/jquery.sparkline.min.js')}}"></script>
--}}
<!-- JQUERY VALIDATE -->
<script src="{{asset('packages/yaro/table-builder/js/plugin/jquery-validate/jquery.validate.min.js')}}"></script>


<script src="{{asset('packages/yaro/table-builder/js/plugin/summernote/summernote.min.js')}}"></script>
<script src="{{asset('packages/yaro/table-builder/js/plugin/summernote/lang/summernote-ru-RU.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('packages/yaro/table-builder/css/summernote.css')}}">

<!-- JQUERY MASKED INPUT -->
<script src="{{asset('packages/yaro/table-builder/js/plugin/masked-input/jquery.maskedinput.min.js')}}"></script>

{{--
<!-- JQUERY SELECT2 INPUT -->
<script src="{{asset('packages/yaro/table-builder/js/plugin/select2/select2.min.js')}}"></script>

<!-- JQUERY UI + Bootstrap Slider -->
<script src="{{asset('packages/yaro/table-builder/js/plugin/bootstrap-slider/bootstrap-slider.min.js')}}"></script>

<!-- browser msie issue fix -->
<script src="{{asset('packages/yaro/table-builder/js/plugin/msie-fix/jquery.mb.browser.min.js')}}"></script>
--}}
<!-- FastClick: For mobile devices -->
<script src="{{asset('packages/yaro/table-builder/js/plugin/fastclick/fastclick.js')}}"></script>

<!--[if IE 7]>

<h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>

<![endif]-->

<!-- Demo purpose only -->
{{--
<script src="{{asset('packages/yaro/table-builder/js/demo.js')}}"></script>

<!-- MAIN APP JS FILE -->
<script src="{{asset('packages/yaro/table-builder/js/app.js')}}"></script>
--}}

<!-- PAGE RELATED PLUGIN(S) -->
<script src="{{asset('packages/yaro/table-builder/js/plugin/datatables/jquery.dataTables-cust.min.js')}}"></script>
<script src="{{asset('packages/yaro/table-builder/js/plugin/datatables/ColReorder.min.js')}}"></script>
<script src="{{asset('packages/yaro/table-builder/js/plugin/datatables/FixedColumns.min.js')}}"></script>
<script src="{{asset('packages/yaro/table-builder/js/plugin/datatables/ColVis.min.js')}}"></script>
<script src="{{asset('packages/yaro/table-builder/js/plugin/datatables/ZeroClipboard.js')}}"></script>
<script src="{{asset('packages/yaro/table-builder/js/plugin/datatables/media/js/TableTools.min.js')}}"></script>
<script src="{{asset('packages/yaro/table-builder/js/plugin/datatables/DT_bootstrap.js')}}"></script>
<script src="{{asset('backend/js/plugin/jquery-nestable/jquery.nestable.min.js')}}"></script>
{{--
<script src="{{asset('packages/yaro/table-builder/js/table.js')}}"></script>
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
    
</script>