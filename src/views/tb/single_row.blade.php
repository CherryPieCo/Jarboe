<tr id-row="{{ $data['id'] }}">
    @foreach ($def['fields'] as $ident => $field)
    @if (!$controller->getField($ident)->getAttribute('hide_list'))

    <td width="{{ $field['width'] or '' }}" class="{{ $field['class'] or '' }} unselectable">
        @if ($controller->getField($ident)->getAttribute('fast-edit'))
            <span class="dblclick-edit selectable">{{ $controller->getField($ident)->getListValue($data['values']) }}</span>
            {{ $controller->getField($ident)->getEditInput($data['values']) }}
            <div class="fast-edit-buttons">
                <button class="btn btn-default btn-mini btn-save" type="button"
                        onclick="TableBuilder.saveFastEdit(this, {{ $data['id'] }}, '{{ $ident }}');">
                    {{ $def['fast-edit']['save']['caption'] or 'Save' }}
                </button>
                <i class="glyphicon glyphicon-remove btn-cancel tip-top" 
                   data-original-title="{{ $def['fast-edit']['cancel']['caption'] or 'Cancel edit' }}"
                   onclick="TableBuilder.closeFastEdit(this, 'cancel');"></i>
            </div>
        @else
            <span>{{ $controller->getField($ident)->getListValue($data['values']) }}</span>
        @endif
    </td>

    @endif
    @endforeach

    <td class="col-action">
        @if (isset($def['actions']['custom']))
            @foreach ($def['actions']['custom'] as $button)
                <a href="{{ url(sprintf($button['link'], $data[$button['params'][0]])) }}">
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
        <button onclick="TableBuilder.getEditForm({{$data['id']}}, this);" 
                class="btn btn-default btn-sm" 
                rel="tooltip" 
                title="" 
                data-placement="bottom" 
                data-original-title="{{ $def['actions']['update']['caption'] or 'Edit #'. $data['id'] }}">
                    <i class="fa fa-pencil"></i>
        </button>
        @endif

        @if (isset($def['actions']['delete']))
        <button class="btn btn-default btn-sm" 
                type="button" 
                rel="tooltip" 
                title="" 
                data-placement="bottom" 
                onclick="TableBuilder.doDelete({{$data['id']}}, this);" 
                data-original-title="{{ $def['actions']['delete']['caption'] or 'Remove #'. $data['id'] }}">
                    <i class="fa fa-times"></i>
        </button>
        @endif
    </td>
</tr>