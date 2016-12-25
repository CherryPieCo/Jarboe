
<input id="{{$name}}"
       name="{{$name}}" 
       value="{{ $value ? : $default }}"
        @if ($type == 'rgba')
           data-color-format="rgba"
        @endif
       type="text" 
       class="form-control input-sm unselectable">


<div style="height: 22px;
            background-color: {{ $value ? : $default }};
            margin-top: -26px;
            margin-right: 4px;
            width: 50px;
            float: right;" class="colorpicker-placeholder-{{$name}}"></div>

<script>
jQuery(document).ready(function() {
    $('#{{$name}}').colorpicker().on('changeColor', function(e) {
        var color = {{ $type == 'rgba' ? 'e.color.toRGB()' : 'e.color.toHex()' }};
        $('.colorpicker-placeholder-{{$name}}').css('background-color', color);
    });
});
</script>