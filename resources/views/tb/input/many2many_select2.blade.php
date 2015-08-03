
<select class="select2-enabled" multiple style="width:100%" name="{{$name}}[]" id="{{$name}}">
    @foreach ($options as $option)
        @foreach ($option as $key => $title)
            <option value="{{$key}}" 
                    @if (isset($selected[$key]))
                        selected="selected"
                    @endif
                    >
                {{ trim($title) }}
            </option>
        @endforeach
    @endforeach
</select>

<script>
jQuery(document).ready(function() {
    jQuery("#{{$name}}").select2(); 
});
</script>