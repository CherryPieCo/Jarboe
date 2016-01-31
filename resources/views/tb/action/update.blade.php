@if (isset($def['mode']) && $def['mode'] == 'new')
<a class="btn btn-default btn-sm" href="?edit={{ $row['id'] }}">
    <i class="fa fa-pencil"></i>
</a>
@else
<a onclick="TableBuilder.getEditForm({{$row['id']}}, this);" 
        class="btn btn-default btn-sm" 
        href="javascript:void(0);" 
        rel="tooltip" 
        title="" 
        data-placement="bottom" 
        data-original-title="{{ $def['caption'] or 'Edit #'. $row['id'] }}">
            <i class="fa fa-pencil"></i>
</a>
@endif