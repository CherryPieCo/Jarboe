<select name="{{ $name }}" class="dblclick-edit-input form-control input-small unselectable">
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
