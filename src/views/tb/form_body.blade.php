@foreach ($def['fields'] as $ident => $field)
<div class="form-group">

    <label class="control-label">{{ $field['caption'] }}</label>
    <div class="controls">
        @if ($is_blank)
            {{ $controller->getField($ident)->getEditInput() }}
        @else
            {{ $controller->getField($ident)->getEditInput($row) }}
        @endif
    </div>

</div>
@endforeach

@if (!$is_blank)
    <input type="hidden" name="id" value="{{ $row['id'] }}" />
@endif

@include('admin::tb.form_actions')