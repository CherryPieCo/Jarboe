
@if ($rows->count())

    @foreach ($rows as $row)
        @include('admin::tb.table.single_row')
    @endforeach
    
@else
    <tr>
        <td colspan="100%">{{ $def['options']['not_found'] or 'No data found' }}</td>
    </tr>
@endif
