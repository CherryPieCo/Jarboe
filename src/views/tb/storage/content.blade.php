
<div class="j-images-storage">

<div class="b-j-catalog-buttons">
    @include('admin::tb.storage.action_buttons')
</div>


<div class="b-j-images">
    <div class="b-j-catalog well">
        @for ($i = 0; $i < 12; $i++)
        <a href="javascript:void(0);" class="btn btn-default btn-sm">button ({{$i}})</a>
        @endfor
    </div>
    @include('admin::tb.storage.images')
</div>
<div style="display: none;" class="b-j-tags">
    <div class="row well">
        @include('admin::tb.storage.tags')
    </div>
</div>
<div style="display: none;" class="b-j-galleries">
    <div class="row well">
        @include('admin::tb.storage.galleries')
    </div>
</div>

</div>



<style>
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
.j-images-storage .b-j-images {
    text-align: center;
}
.j-images-storage .b-j-tags {

}
.j-images-storage .b-j-galleries {

}
</style>


<script>
    Superbox.fields.image = {{ json_encode(\Config::get('jarboe::images.image.fields') ? : array()) }};
    Superbox.init();
</script>


