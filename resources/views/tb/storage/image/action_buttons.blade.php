<div style="overflow: auto;" class="well">
    <form class="smart-form pull-left">
    <div class="input input-file" style="width: 350px;">
        <span class="button">
            <input type="file" name="images[]" multiple="multiple" accept="image/*" onchange="Superbox.uploadImage(this);">
            Выбрать
        </span>
        <input type="text" class="j-image-title" placeholder="Название изображения">
    </div>
    </form>
                                                    
    <div style="width: 30%;" class="btn-group btn-group-justified pull-right">
        <a href="javascript:void(0);" onclick="Superbox.showGalleries(this);" 
            class="btn btn-default {{ $type == 'gallery' ? 'active' : '' }}">Галереи</a>
        <a href="javascript:void(0);" onclick="Superbox.showImages(this);" 
            class="btn btn-default {{ in_array($type, ['image', 'redactor_image']) ? 'active' : '' }} j-images-img-action">Изображения</a>
        <a href="javascript:void(0);" onclick="Superbox.showTags(this);" 
            class="btn btn-default {{ $type == 'tag' ? 'active' : '' }}">Теги</a>
    </div>
</div>