
<tr>
    @if (isset($def['options']['is_sortable']) && $def['options']['is_sortable'])
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
    
    @if (isset($def['multi_actions']))
        <th><label class="checkbox multi-checkbox multi-main-checkbox" onclick="TableBuilder.doSelectAllMultiCheckboxes(this);">
            <input type="checkbox" /><i></i>
        </label></th>
    @endif
    
    @foreach ($def['fields'] as $ident => $options)
    <?php 
    $field = $controller->getField($ident); 
    if ($field->isPattern()) {
        continue;
    }
    
    $order = Session::get('table_builder.'.$controller->getOption('def_name').'.order', array());
    ?>
    @if (!$field->getAttribute('hide_list'))
        @if ($field->getAttribute('is_sorting'))
            @if ($order && $order['field'] == $ident)
                <th class="sorting sorting_{{$order['direction']}}" 
                    onclick="TableBuilder.doChangeSortingDirection('{{$ident}}',this);">
                        {{ $options['caption'] }}
                </th>
            @else
                <th class="sorting" 
                    onclick="TableBuilder.doChangeSortingDirection('{{$ident}}',this);">
                        {{ $options['caption'] }}
                </th>
            @endif
        @else
            <th>{{ $options['caption'] }}</th>
        @endif
    @endif
    @endforeach

    @if (isset($def['actions']['insert']))
    <th class="e-insert_button-cell" style="min-width: 69px;">
        {{ $controller->actions->fetch('insert') }}
    </th>
    @else
        <th></th>
    @endif
</tr>

@if ($def['is_searchable'])
<tr class="filters-row">
    @if (isset($def['options']['is_sortable']) && $def['options']['is_sortable'])
        <th></th>
    @endif
    
    @if (isset($def['multi_actions']))
        <th></th>
    @endif
    
    @foreach ($def['fields'] as $ident => $options)
    <?php $field = $controller->getField($ident); ?>
    @if (!$field->isPattern() && !$field->getAttribute('hide_list'))
        <td>{{ $field->getFilterInput() }}</td>
    @endif
    @endforeach

    <td style="width:1%">
        <button class="btn btn-default btn-sm tb-search-btn" style="min-width: 66px;"
                type="button"
                onclick="TableBuilder.search();">
            {{ $def['actions']['search']['caption'] or 'Search' }}
        </button>
    </td>
</tr>
@endif