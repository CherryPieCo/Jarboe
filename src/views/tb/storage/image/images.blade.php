<!-- row -->
<div class="row well">

    <!-- SuperBox -->
    <div class="superbox col-sm-12">
        @foreach ($images as $image)
            @include('admin::tb.storage.image.single_image')
        @endforeach
        
        <div class="superbox-float"></div>
    </div>
    <!-- /SuperBox -->
    
    <div class="superbox-show" style="height: 300px; display: none;"></div>

</div>
