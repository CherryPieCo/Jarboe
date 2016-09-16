<td class="col-action">
    
    @if (isset($def->getActions()['custom']))
        @foreach ($def['actions']['custom'] as $button)
        
            {!! $actions->fetch('custom', $row, $button) !!}
            
        @endforeach
    @endif
    
    
    {!! $actions->fetch('restore', $row) !!}
    
    {!! $actions->fetch('update', $row) !!}
    
    {!! $actions->fetch('delete', $row) !!}

</td>