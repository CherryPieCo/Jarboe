@if ($rows->count())
@foreach ($rows as $row)
<tr id-row="{{ $row['id'] }}">
    @foreach ($def['fields'] as $ident => $field)
    @if (!$controller->getField($ident)->getAttribute('hide'))

    <td width="{{ $field['width'] or '' }}" class="{{ $field['class'] or '' }} unselectable">
        @if ($controller->getField($ident)->getAttribute('fast-edit'))
            <span class="dblclick-edit selectable">{{ $controller->getField($ident)->getListValue($row) }}</span>
            {{ $controller->getField($ident)->getEditInput($row) }}

            <textarea class="tb-previous-value"></textarea>
            <div class="fast-edit-buttons">
                <button class="btn btn-default btn-mini btn-save" type="button"
                        onclick="TableBuilder.saveFastEdit(this, {{ $row['id'] }}, '{{ $ident }}');">
                    {{ $def['fast-edit']['save']['caption'] or 'Save' }}
                </button>
                <i class="glyphicon glyphicon-remove btn-cancel tip-top" 
                   data-original-title="{{ $def['fast-edit']['cancel']['caption'] or 'Cancel edit' }}"
                   onclick="TableBuilder.closeFastEdit(this, 'cancel');"></i>
            </div>
        @else
            <span>{{ $controller->getField($ident)->getListValue($row) }}</span>
        @endif
    </td>

    @endif
    @endforeach

    <td class="col-action">
        @if (isset($def['actions']['update']))
        <button class="btn btn-inverse btn-mini tip-top" type="button"
                onclick="TableBuilder.showEditForm({{ $row['id'] }});"
                data-original-title="{{ $def['actions']['update']['caption'] or 'Edit #'. $row['id'] }}">
            <i class="glyphicon glyphicon-pencil"></i>
        </button>
        @endif

        @if (isset($def['actions']['delete']))
        <button class="btn btn-inverse btn-mini tip-top" type="button"
                onclick="TableBuilder.delete({{ $row['id'] }});"
                data-original-title="{{ $def['actions']['delete']['caption'] or 'Remove #'. $row['id'] }}">
            <i class="glyphicon glyphicon-remove"></i>
        </button>
        @endif
    </td>
</tr>
@endforeach
@else
    <tr><td colspan=100%>{{ $def['options']['not_found'] or 'No data found' }}</td></tr>
@endif
