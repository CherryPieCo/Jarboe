<link rel="stylesheet" type="text/css" href="{{asset('packages/barryvdh/laravel-elfinder/css/elfinder.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('packages/barryvdh/laravel-elfinder/css/theme.css')}}">
<script src="{{asset('packages/barryvdh/laravel-elfinder/js/elfinder.min.js')}}"></script>
<script src="{{asset('packages/barryvdh/laravel-elfinder/js/i18n/elfinder.ru.js')}}"></script>



<!-- widget grid -->
<section id="widget-grid" class="">
    <!-- row -->
    <div class="row" style="padding-right: 13px; padding-left: 13px;">
        <!-- NEW WIDGET START -->
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-right: 0px; padding-left: 0px;">
            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-1" 
                data-widget-editbutton="false"
                data-widget-colorbutton="false"
                data-widget-deletebutton="false"
                data-widget-sortable="false">
                <!-- widget options:
                data-widget-colorbutton="false"
                data-widget-editbutton="false"
                data-widget-togglebutton="false"
                data-widget-deletebutton="false"
                data-widget-fullscreenbutton="false"
                data-widget-custombutton="false"
                data-widget-collapsed="true"
                data-widget-sortable="false"
                -->
                <header>
                    <span class="widget-icon"> <i class="fa fa-list-alt"></i> </span>
                    <h2></h2>
                </header>
                <div>
                    <div class="jarviswidget-editbox">
                    </div>
                    <div class="widget-body no-padding">
                        
                        <div id="{{$ident}}"></div>
                        
                    </div>
                </div>
            </div>
        </article>
    </div>
</section>




<script type="text/javascript" charset="utf-8">
    // Helper function to get parameters from the query string.
    function getUrlParam(paramName) {
        var reParam = new RegExp('(?:[\?&]|&amp;)' + paramName + '=([^&]+)', 'i');
        var match = window.location.search.match(reParam) ;

        return (match && match.length > 1) ? match[1] : '';
    }

    jQuery(document).ready(function() {
        var funcNum = getUrlParam('CKEditorFuncNum');

        var elf = jQuery('#{{$ident}}').elfinder({
            // set your elFinder options here
            lang: 'ru', // locale
            url: '{{ url($connector) }}',  // connector URL
            handlers : {
                dblclick : function(event, elfinderInstance) {
                    event.preventDefault();
                    elfinderInstance.exec('getfile')
                        .done(function() { elfinderInstance.exec('quicklook'); })
                        .fail(function() { elfinderInstance.exec('open'); });
                }
            },
            
            getFileCallback : function(files, fm) {
                return false;
            },
            
            commandsOptions : {
                quicklook : {
                    width : 480,  // Set default width/height voor quicklook
                    height : 320
                }
            }
        }).elfinder('instance');
    });
</script>
