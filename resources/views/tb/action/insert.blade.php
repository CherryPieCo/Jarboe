@if (isset($def['mode']) && $def['mode'] == 'new')
<a class="btn btn-default btn-sm" href="?make=mimimi" style="min-width: 70px;">
    {{ $def['caption'] or 'Add' }}
</a>
@else
<a class="btn btn-default btn-sm" style="min-width: 70px;"
        href="javascript:void(0);" 
        onclick="TableBuilder.getCreateForm();">
    {{ $def['caption'] or 'Add' }}
</a>
@endif