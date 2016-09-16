


<?php
$trColor = '';
foreach ($def->getFields() as $field) {
    if (!$trColor && !$field->isPattern() && !$field->getAttribute('hide_list') && $field->getAttribute('is_tr_color')) {
        $trColor = $field->getRowColor($row);
    }
}
?>


    <tr id-row="{{ $row->id }}" id="sort-{{ $row->id }}">
        @if ($def->getOption('is_sortable'))
        <td class="tb-sort-me-gently" style="cursor:s-resize;">
            <i class="fa fa-sort"></i>
        </td>
        @endif
    
    @if (false && isset($def['multi_actions']))
        <td><label class="checkbox multi-checkbox"><input type="checkbox" value="{{$row['id']}}" name="multi_ids[]" /><i></i></label></td>
    @endif
    
    
    @foreach ($def->getFields() as $field)
        @if ($field->isPattern())
            @if (!$field->getAttribute('hide_list'))
                <td>{!! $field->renderList($row) !!}</td>
            @endif
            @continue
        @endif
        
        @if (!$field->getAttribute('hide_list'))
        <td style="background-color: {{ $trColor }}; background-color: {{ $field->getRowColor($row) }};" width="{{ $field->getAttribute('width') }}" class="{{ $field->getAttribute('class') }} ">
            @if ($field->isInlineEdit())
                <div class="tb-inline-edit-container">
                    {!! $field->getInlineEditInput($row) !!}
                </div>
            @else
                @if ($field->isShowRawListValue())
                    {!! $field->getListValue($row) !!}
                @else 
                    <span>{!! $field->getListValue($row) !!}</span>
                @endif
            @endif
        </td>
    
        @endif
    @endforeach

    {!! $controller->view->fetchActions($row) !!}
    
</tr>

<?php  $trColor = ''; ?>