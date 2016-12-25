<a class="btn btn-default btn-sm" 
        href="javascript:void(0);" 
        rel="tooltip" 
        title="" 
        data-placement="bottom" 
        onclick="TableBuilder.doDelete({{$row->id}}, this);" 
        data-original-title="{{ $def['caption'] or 'Remove #'. $row->id }}">
            <i class="fa fa-times"></i>
</a>