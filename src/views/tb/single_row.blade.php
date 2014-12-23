
<?php
$trColor = '';
foreach ($def['fields'] as $ident => $field) {
    if (!$trColor && !$controller->getField($ident)->getAttribute('hide_list') && $controller->getField($ident)->getAttribute('is_tr_color')) {
        $trColor = $controller->getField($ident)->getRowColor($row);
    }
}
?>

<tr id-row="{{ $row['id'] }}">
    @if (isset($def['multi_actions']))
        <td><label class="checkbox multi-checkbox"><input type="checkbox" value="{{$row['id']}}" name="multi_ids[]" /><i></i></label></td>
    @endif
    
    @foreach ($def['fields'] as $ident => $field)
    @if (!$controller->getField($ident)->getAttribute('hide_list'))
    <?php $field = $controller->getField($ident) ?>
    <td style="background-color: {{ $trColor }}; background-color: {{ $field->getRowColor($row) }};" width="{{ $field->getAttribute('width') }}" class="{{ $field->getAttribute('class') }} unselectable">
        @if ($field->getAttribute('fast-edit'))
            <span class="dblclick-edit selectable">{{ $field->getListValue($row) }}</span>
            {{ $field->getEditInput($row) }}
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
            <span>{{ $field->getListValue($row) }}</span>
        @endif
    </td>

    @endif
    @endforeach

    {{ $controller->view->fetchActions($row) }}
    
</tr>

<?php  $trColor = ''; ?>