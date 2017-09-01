


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
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
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



<!-- JQUERY MASKED INPUT -->
<script src="{{asset('packages/yaro/jarboe/js/plugin/masked-input/jquery.maskedinput.min.js')}}"></script>

{{--
<script src="{{asset('packages/yaro/jarboe/js/plugin/bootstrap-timepicker/bootstrap-timepicker.min.js')}}"></script>
<!-- JQUERY UI + Bootstrap Slider -->
<script src="{{asset('packages/yaro/jarboe/js/plugin/bootstrap-slider/bootstrap-slider.min.js')}}"></script>

<!-- browser msie issue fix -->
<script src="{{asset('packages/yaro/jarboe/js/plugin/msie-fix/jquery.mb.browser.min.js')}}"></script>

<!-- FastClick: For mobile devices -->
<script src="{{asset('packages/yaro/jarboe/js/plugin/fastclick/fastclick.js')}}"></script>
--}}
<!--[if IE 7]>

<h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>

<![endif]-->

<link href="{{ asset('packages/yaro/jarboe/js/plugin/redactor/redactor.css') }}" rel="stylesheet" type="text/css">
<script src="{{ asset('packages/yaro/jarboe/js/plugin/redactor/redactor.min.js') }}"></script>
<script src="{{ asset('packages/yaro/jarboe/js/plugin/redactor/table.js') }}"></script>
<script src="{{ asset('packages/yaro/jarboe/js/plugin/redactor/imagemanager.js') }}"></script>

@foreach (Jarboe::getAssets('css') as $css) 
    <link href="{{ asset($css) }}" rel="stylesheet" type="text/css">
@endforeach

@foreach (Jarboe::getAssets('js') as $js) 
    <script src="{{ asset($js) }}"></script>
@endforeach

<!-- PAGE RELATED PLUGIN(S) -->
{{--
<script src="{{asset('packages/yaro/jarboe/js/plugin/datatables/jquery.dataTables-cust.min.js')}}"></script>
<script src="{{asset('packages/yaro/jarboe/js/plugin/datatables/ColReorder.min.js')}}"></script>
<script src="{{asset('packages/yaro/jarboe/js/plugin/datatables/FixedColumns.min.js')}}"></script>
<script src="{{asset('packages/yaro/jarboe/js/plugin/datatables/ColVis.min.js')}}"></script>
<script src="{{asset('packages/yaro/jarboe/js/plugin/datatables/ZeroClipboard.js')}}"></script>
<script src="{{asset('packages/yaro/jarboe/js/plugin/datatables/media/js/TableTools.min.js')}}"></script>
<script src="{{asset('packages/yaro/jarboe/js/plugin/datatables/DT_bootstrap.js')}}"></script>
<script src="{{asset('packages/yaro/jarboe/js/plugin/jquery-nestable/jquery.nestable.min.js')}}"></script>
--}}



{{--
<script src="{{asset('packages/yaro/jarboe/js/table.js')}}"></script>
--}}


<style type="text/css">

</style>

<script type="text/javascript">
    TBMenu.admin_uri = '{{ config('jarboe.admin.uri') }}';
    pageSetUp();
</script>



