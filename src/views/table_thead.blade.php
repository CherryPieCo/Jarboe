<tr>
    @foreach ($def['fields'] as $ident => $field)
    @if (!$controller->getField($ident)->getAttribute('hide'))
        <th>{{ $field['caption'] }}</th>
    @endif
    @endforeach

    @if (isset($def['actions']['insert']))
    <th class="e-insert_button-cell">
        <button class="btn btn-default btn-mini" 
                type="button"
                onclick="TableBuilder.insert();">
            {{ $def['actions']['insert']['caption'] or 'Add' }}
        </button>
    </th>
    @else
        <th></th>
    @endif
</tr>

@if ($def['is_searchable'])
<tr class="row-filters">
    @foreach ($def['fields'] as $ident => $field)
    @if (!$controller->getField($ident)->getAttribute('hide'))
        <th>{{ $controller->getField($ident)->getFilterInput() }}</th>
    @endif
    @endforeach

    <th>
        <button class="btn btn-default btn-mini" 
                type="button"
                onclick="TableBuilder.search();">
            {{ $def['actions']['search']['caption'] or 'Search' }}
        </button>
    </th>
</tr>
@endif