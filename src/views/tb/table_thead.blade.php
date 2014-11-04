
<tr>
    @if (isset($def['multi_actions']))
        <th><label class="checkbox multi-checkbox multi-main-checkbox" onclick="TableBuilder.doSelectAllMultiCheckboxes(this);">
            <input type="checkbox" /><i></i>
        </label></th>
    @endif
    
    @foreach ($def['fields'] as $ident => $options)
    <?php 
    $field = $controller->getField($ident); 
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
    <th class="e-insert_button-cell">
        {{ $controller->actions->fetch('insert') }}
    </th>
    @else
        <th></th>
    @endif
</tr>

@if ($def['is_searchable'])
<tr class="filters-row">
    @if (isset($def['multi_actions']))
        <th></th>
    @endif
    
    @foreach ($def['fields'] as $ident => $options)
    <?php $field = $controller->getField($ident); ?>
    @if (!$field->getAttribute('hide_list'))
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