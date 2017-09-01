@extends('admin::layouts.default')


@section('main')

    <!-- MAIN CONTENT -->
    <div id="content">
        <div class="row">
        
            @include('admin::tb.storage.image.content', array('type' => 'none'))

        </div>
    </div>
    <!-- END MAIN CONTENT -->

    <script>
        TableBuilder.options = true; 
        TableBuilder.options.action_url = '{{ Request::url() }}';
        $(document).ready(function() {
            Superbox.images_page = 1;
            $('.j-images-img-action').trigger('click');
            Superbox.init();
            
            $(document).scroll(function() {
                if ($(document).scrollTop() + $(window).height() == $(document).height()) {
                    if ($('.j-images-img-action').hasClass('active')) {
                        Superbox.loadMoreImages();
                    }
                }
            });
        });
    </script>
@stop

