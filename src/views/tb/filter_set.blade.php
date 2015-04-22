<select name="filter[{{ $name }}]" class="form-control input-small">
    <option></option>
    @foreach ($options as $value => $caption)
        @if ($value === $filter)
            <option value="{{ $value }}" selected>{{ $caption }}</option>
        @else
            <option value="{{ $value }}">{{ $caption }}</option>
        @endif
    @endforeach
</select>