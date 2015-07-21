<select id="many2many-f-select2-{{ $name }}-{{ $postfix }}" name="{{ $name }}" class="dblclick-edit-input form-control input-small select2-enabled ">
    @if ($is_null)
        <option value="">{{ $null_caption ? : '...' }}</option>
    @endif
    
    @foreach ($options as $value => $caption)
        @if ($caption == $selected)
            <option value="{{ $value }}" selected>{{ $caption }}</option>
        @else
            <option value="{{ $value }}">{{ $caption }}</option>
        @endif
    @endforeach
</select>

<script>
    jQuery(document).ready(function() {
        jQuery('#many2many-f-select2-{{ $name }}-{{ $postfix }}').select2();
    });
    TableBuilder.initSelect2Hider();
</script>

<style>
#s2id_many2many-f-select2-{{ $name }}-{{ $postfix }} {
    border: none;
}
</style>
