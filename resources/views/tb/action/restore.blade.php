<a class="btn btn-default btn-sm" 
        href="javascript:void(0);" 
        rel="tooltip" 
        title="" 
        data-placement="bottom" 
        onclick="TableBuilder.doRestore({{$row['id']}}, this);" 
        data-original-title="{{ $def['caption'] or 'Restore #'. $row['id'] }}">
            <i class="fa fa-history"></i>
</a>