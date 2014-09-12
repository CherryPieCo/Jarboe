
<li
    @if ($item['is_active'])
       class="active open"
    @endif
    >
    
    @if (isset($item['submenu']))
        <a href="#" 
           title="{{$item['title']}}">
            @if (isset($item['icon']))
                <i class="fa fa-lg fa-fw fa-{{$item['icon']}}"></i> 
            @endif
            <span class="menu-item-parent">{{$item['title']}}</span>
        </a>
        <ul>
        @foreach ($item['submenu'] as $submenu)
            @include('admin::partials.navigation_row_children', array('item' => $submenu))
        @endforeach
        </ul>
    @else
        @include('admin::partials.navigation_row', array('item' => $item))
    @endif

</li>