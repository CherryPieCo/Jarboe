
<div style="position: relative;">
    <input type="text" value="{{ $value }}" name="filter[{{ $name }}]" class="form-control input-small" />
    @if ($value)
    <button onclick="$(this).parent().find('input').val(''); setTimeout(function(){ TableBuilder.search(); }, 200);" class="close" style="position: absolute; top: 8px; right: 6px;">
        ×
    </button>
    @endif
</div>
