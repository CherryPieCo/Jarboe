
<tr>
    @if ($def->getOption('is_sortable'))
        <th style="width: 1%; padding: 0;">
            <i style="margin-left: -10px;" class="fa fa-reorder"></i>
        </th>
        
        <script>
            jQuery(document).ready(function() {
                jQuery('.tb-sort-me-gently', '.tb-table').on('mousedown', function() {
                    jQuery('.widget-body', '.table-builder').css('overflow-x', 'visible');
                });
                jQuery('.tb-sort-me-gently', '.tb-table').on('mouseup', function() {
                    jQuery('.widget-body', '.table-builder').css('overflow-x', 'scroll');
                });
                jQuery('tbody', '#datatable_fixed_column').sortable({
                    //start: function(event, ui) {
                    //    jQuery('.widget-body', '.table-builder').css('overflow-x', 'visible');
                    //}, // end start
                    //stop: function(event, ui) {
                    //    jQuery('.widget-body', '.table-builder').css('overflow-x', 'scroll');
                    //}, // end stop
                    scroll: true,
                    axis: "y",
                    handle: ".tb-sort-me-gently",
                    update: function () {
                        var order = jQuery('tbody', '#datatable_fixed_column').sortable("serialize");
                        TableBuilder.saveOrder(order);
                    }
                });
            });
        </script>
    @endif
    
    @if (false && isset($def['multi_actions']))
        <th><label class="checkbox multi-checkbox multi-main-checkbox" onclick="TableBuilder.doSelectAllMultiCheckboxes(this);">
            <input type="checkbox" /><i></i>
        </label></th>
    @endif
    
    @foreach ($def->getFields() as $field)
    
    @if ($field->isPattern()) 
        @if (!$field->getAttribute('hide_list')) 
            <th>{{ $field->getAttribute('caption') }}</th>
        @endif
        @continue
    @endif
    
    <?php $order = session()->get('table_builder.'.$controller->getOption('def_name').'.order', array()); ?>
    @if (!$field->getAttribute('hide_list'))
        @if ($field->getAttribute('is_sorting'))
            @if ($order && $order['field'] == $field->getFieldName())
                <th class="sorting sorting_{{$order['direction']}}" 
                    onclick="TableBuilder.doChangeSortingDirection('{{$field->getFieldName()}}',this);">
                        {{ $field->getAttribute('caption') }}
                </th>
            @else
                <th class="sorting" 
                    onclick="TableBuilder.doChangeSortingDirection('{{$field->getFieldName()}}',this);">
                        {{ $field->getAttribute('caption') }}
                </th>
            @endif
        @else
            <th>{{ $field->getAttribute('caption') }}</th>
        @endif
    @endif
    @endforeach

    @if (isset($def->getActions()['insert']))
    <th class="e-insert_button-cell" style="min-width: 69px;">
        {!! $controller->actions->fetch('insert') !!}
    </th>
    @else
        <th></th>
    @endif
</tr>

@if ($def->isSearchable())
<tr class="filters-row">
    @if ($def->getOption('is_sortable'))
        <th></th>
    @endif 
    
    @if (false && isset($def['multi_actions']))
        <th></th>
    @endif
    
    @foreach ($def->getFields() as $field)
        @if ($field->isPattern()) 
            @if (!$field->getAttribute('hide_list')) 
                <td></td>
            @endif
            @continue
        @endif
        
        @if (!$field->getAttribute('hide_list'))
            <td>{!! $field->getFilterInput() !!}</td>
        @endif
    @endforeach

    <td style="width:1%">
        <button class="btn btn-default btn-sm tb-search-btn" style="min-width: 66px;"
                type="button"
                onclick="TableBuilder.search();">
            Search
        </button>
    </td>
</tr>
@endif