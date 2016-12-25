
@if (isset($def['mode']) && $def['mode'] == 'new')
<a class="btn btn-default btn-sm" href="?edit={{ $row->id }}">
    <i class="fa fa-pencil"></i>
</a>
@else
<a onclick="TableBuilder.getEditForm({{$row->id}}, this);" class="btn btn-default btn-sm" href="javascript:void(0);">
    <i class="fa fa-pencil"></i>
</a>
@endif
