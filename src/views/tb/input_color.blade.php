
<input id="{{$name}}"
       name="{{$name}}" 
       value="{{ $value ? : $default }}"
        @if ($type == 'rgba')
           data-color-format="rgba"
        @endif
       type="text" 
       class="form-control input-sm unselectable">
       
<script>
jQuery(document).ready(function() {
    $('#{{$name}}').colorpicker();
});
</script>