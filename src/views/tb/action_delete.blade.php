<button class="btn btn-default btn-sm" 
        type="button" 
        rel="tooltip" 
        title="" 
        data-placement="bottom" 
        onclick="TableBuilder.doDelete({{$row['id']}}, this);" 
        data-original-title="{{ $def['caption'] or 'Remove #'. $row['id'] }}">
            <i class="fa fa-times"></i>
</button>