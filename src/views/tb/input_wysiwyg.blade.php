<div id="{{$name}}-wysiwyg">{{ $value }}</div>
<textarea id="{{$name}}" name="{{ $name }}" style="display:none;" class="hidden">{{ $value }}</textarea>
<script type="text/javascript">
    jQuery(document).ready(function() {
      jQuery('#{{$name}}-wysiwyg').summernote({
          lang: 'ru-RU',
          onblur: function(e) {
              jQuery('#{{$name}}').html(jQuery('#{{$name}}-wysiwyg').code());
          },
          onImageUpload: function(files, editor, $editable) {
              TableBuilder.uploadImageFromWysiwygSummertime(files, editor, $editable);
          }
      });
    });
</script>
