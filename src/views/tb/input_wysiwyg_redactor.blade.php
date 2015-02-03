


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
        });
    });
</script>

