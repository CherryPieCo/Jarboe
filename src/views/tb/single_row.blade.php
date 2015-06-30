


<?php
$trColor = '';
foreach ($def['fields'] as $ident => $field) {
    if (!$trColor && !$controller->getField($ident)->isPattern() && !$controller->getField($ident)->getAttribute('hide_list') && $controller->getField($ident)->getAttribute('is_tr_color')) {
        $trColor = $controller->getField($ident)->getRowColor($row);
    }
}
?>


    <tr id-row="{{ $row['id'] }}" id="sort-{{ $row['id'] }}">
        @if (isset($def['options']['is_sortable']) && $def['options']['is_sortable'])
        <td class="tb-sort-me-gently" style="cursor:s-resize;">
            <i class="fa fa-sort"></i>
        </td>
        @endif
    
    @if (isset($def['multi_actions']))
        <td><label class="checkbox multi-checkbox"><input type="checkbox" value="{{$row['id']}}" name="multi_ids[]" /><i></i></label></td>
    @endif
    
    @foreach ($def['fields'] as $ident => $field)
    <?php $field = $controller->getField($ident) ?>
    @if ($field->isPattern())
        @continue
    @endif
    
    
    @if (!$field->getAttribute('hide_list'))
    <td style="background-color: {{ $trColor }}; background-color: {{ $field->getRowColor($row) }};" width="{{ $field->getAttribute('width') }}" class="{{ $field->getAttribute('class') }} ">
        @if ($field->isInlineEdit())
            <div class="tb-inline-edit-container">
                {{ $field->getInlineEditInput($row) }}
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