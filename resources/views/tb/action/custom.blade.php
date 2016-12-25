<a href="{{ url(sprintf($def['link'], $row[$def['params'][0]])) }}">
<a class="btn btn-default btn-sm" 
        href="javascript:void(0);" 
        rel="tooltip" 
        title="{{ $def['caption'] }}" 
        data-placement="bottom" 
        data-original-title="{{ $def['caption'] }}">
            <i class="fa fa-{{$def['icon']}}"></i>
</a>
</a>