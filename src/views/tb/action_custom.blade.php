<a href="{{ url(sprintf($def['link'], $row[$def['params'][0]])) }}">
<button class="btn btn-default btn-sm" 
        type="button" 
        rel="tooltip" 
        title="{{ $def['caption'] }}" 
        data-placement="bottom" 
        data-original-title="{{ $def['caption'] }}">
            <i class="fa fa-{{$def['icon']}}"></i>
</button>
</a>