@if ($rows->count())
@foreach ($rows as $row)

    @include('admin::tb.single_row')

{{--
<tr id-row="{{ $row['id'] }}">
    @foreach ($def['fields'] as $ident => $field)
    @if (!$controller->getField($ident)->getAttribute('hide_list'))

    <td width="{{ $field['width'] or '' }}" class="{{ $field['class'] or '' }} unselectable">
        @if ($controller->getField($ident)->getAttribute('fast-edit'))
            <span class="dblclick-edit selectable">{{ $controller->getField($ident)->getListValue($row) }}</span>
            {{ $controller->getField($ident)->getEditInput($row) }}
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
        @if (isset($def['actions']['custom']))
            @foreach ($def['actions']['custom'] as $button)
                <a href="{{ url(sprintf($button['link'], $row[$button['params'][0]])) }}">
                <button class="btn btn-default btn-sm" 
                        type="button" 
                        rel="tooltip" 
                        title="{{ $button['caption'] }}" 
                        data-placement="bottom" 
                        data-original-title="{{ $button['caption'] }}">
                            <i class="fa fa-{{$button['icon']}}"></i>
                </button>
                </a>
            @endforeach
        @endif
        
        
        @if (isset($def['actions']['update']))
        <button onclick="TableBuilder.getEditForm({{$row['id']}}, this);" 
                class="btn btn-default btn-sm" 
                rel="tooltip" 
                title="" 
                type="button"
                data-placement="bottom" 
                data-original-title="{{ $def['actions']['update']['caption'] or 'Edit #'. $row['id'] }}">
                    <i class="fa fa-pencil"></i>
        </button>
        @endif

        @if (isset($def['actions']['delete']))
        <button class="btn btn-default btn-sm" 
                type="button" 
                rel="tooltip" 
                title="" 
                type="button"
                data-placement="bottom" 
                onclick="TableBuilder.doDelete({{$row['id']}}, this);" 
                data-original-title="{{ $def['actions']['delete']['caption'] or 'Remove #'. $row['id'] }}">
                    <i class="fa fa-times"></i>
        </button>
        @endif
    </td>
</tr>
--}}
@endforeach
@else
    <tr><td colspan="100%">{{ $def['options']['not_found'] or 'No data found' }}</td></tr>
@endif
