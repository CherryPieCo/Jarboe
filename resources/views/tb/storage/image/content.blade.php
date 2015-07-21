
<div class="j-images-storage">

<div class="b-j-catalog-buttons">
    @include('admin::tb.storage.image.action_buttons')
</div>


<div {{ in_array($type, ['image', 'redactor_image']) ? '' : 'style="display: none;"' }} class="b-j-images">
    <?php /*
    <div class="b-j-catalog well">
        @for ($i = 0; $i < 12; $i++)
        <a href="javascript:void(0);" class="btn btn-default btn-sm">button ({{$i}})</a>
        @endfor
        
    </div>
    */ ?>
    
    @include('admin::tb.storage.image.images_search')
    <div id="j-images-container">
        @include('admin::tb.storage.image.images')
    </div>
</div>

<div {{ $type == 'tag' ? '' : 'style="display: none;"' }} class="b-j-tags">
    <div class="row well">
        @include('admin::tb.storage.image.tags')
    </div>
</div>
<div {{ $type == 'gallery' ? '' : 'style="display: none;"' }} class="b-j-galleries">
    <div class="row well">
        @include('admin::tb.storage.image.galleries')
    </div>
</div>

</div>



<style>
div#ui-datepicker-div {
    z-index: 999999 !important;
}
div.select2-drop {
    z-index: 8888881;
}
div#divSmallBoxes {
    z-index: 999909;
}
img.superbox-current-img {
    width: 60%;
}
div.superbox-imageinfo {
    width: 40%;
}
.j-images-storage .b-j-catalog-buttons {
    background-color: rgb(241, 240, 255);
}
.j-images-storage .b-j-catalog {
    background-color: aliceblue;
    text-align: left;
}
.j-images-storage .b-j-search {
    background-color: rgb(251, 251, 251);
    padding: 0;
}
.j-images-storage .b-j-images {
    text-align: center;
}
.j-images-storage .b-j-tags {

}
.j-images-storage .b-j-galleries {

}
</style>


<script>
    Superbox.images_page = 1;
    Superbox.fields.image = {{ json_encode(\config('jarboe::images.image.fields') ? : array()) }};
    Superbox.init();
    $('.image_storage_wrapper').scroll(function() {
        if ($('.image_storage_wrapper').scrollTop() + $('.image_storage_wrapper').height() == $('#modal_image_storage_wrapper').innerHeight()) {
            if ($('.j-images-img-action').hasClass('active')) {
                Superbox.loadMoreImages();
            }
        }
    });
    
    $('.j-datepicker').datepicker();
</script>


