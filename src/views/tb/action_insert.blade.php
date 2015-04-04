@if (isset($def['mode']) && $def['mode'] == 'new')
<a class="btn btn-default btn-sm" href="?make=mimimi" style="min-width: 70px;">
    {{ $def['caption'] or 'Add' }}
</a>
@else
<button class="btn btn-default btn-sm" style="min-width: 70px;"
        type="button"
        onclick="TableBuilder.getCreateForm();">
    {{ $def['caption'] or 'Add' }}
</button>
@endif