


<textarea id="{{$name}}-wysiwyg" name="{{ $name }}">{{ $value }}</textarea>
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery('#{{$name}}-wysiwyg').redactor({
            @foreach ($extraOptions as $key => $val)
                {{$key}}: {{$val}},
            @endforeach
            buttonSource: true,
            pasteCallback: function(html) {
                var redactor = this;
                jQuery.ajax({
                    type: "POST",
                    // FIXME: move action url to options
                    url: TableBuilder.admin_prefix +'/tb/embed-to-text',
                    data: {text: redactor.code.get()},
                    dataType: 'json',
                    success: function(response) {
                        if (response.status) {
                            console.log(response);
                            redactor.code.set(response.html);
                        } else {
                            TableBuilder.showErrorNotification('Что-то пошло не так');
                        }
                    }
                });
                return html;
            },
            imageUpload: '{{ url($action) }}?query_type=redactor_image_upload',
            imageUploadCallback: function(image, json) {
                console.log(this);
                console.log(image);
                console.log(json);
                //TableBuilder.uploadImageFromWysiwygSummertime(files, editor, $editable);
            },
            <?php // FIXME: ?>
            imageManagerJson: '{{ url($action) }}?query_type=image_storage&storage_type=get_redactor_images_list&__node={{ \Input::get('__node', 1) }}',
            plugins: ['imagemanager', 'table']
        });
    });
</script>

