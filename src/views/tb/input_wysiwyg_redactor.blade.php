


<textarea id="{{$name}}-wysiwyg" name="{{ $name }}">{{ $value }}</textarea>
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery('#{{$name}}-wysiwyg').redactor({
            buttonSource: true,
            imageUpload: '{{ url($action) }}?query_type=redactor_image_upload',
            imageUploadCallback: function(image, json) {
                console.log(this);
                console.log(image);
                console.log(json);
                //TableBuilder.uploadImageFromWysiwygSummertime(files, editor, $editable);
            },
            <?php // FIXME: ?>
            imageManagerJson: '{{ url($action) }}?query_type=image_storage&storage_type=get_redactor_images_list&__node={{ \Input::get('__node') }}',
            plugins: ['imagemanager', 'table']
        });
    });
</script>

