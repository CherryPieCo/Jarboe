
<select name="filter[{{ $name }}]" class="form-control input-small">
    <option value=""></option>
    
    @foreach ($options as $value => $caption)
        @if ($value == $selected)
            <option value="{{ $value }}" selected>{{ $caption }}</option>
        @else
            <option value="{{ $value }}">{{ $caption }}</option>
        @endif
    @endforeach
</select>