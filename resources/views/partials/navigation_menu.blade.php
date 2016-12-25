
@foreach ($menu as $item)
    <li
        @if ($item['is_active'])
           class="active 
           @if (isset($submenu['submenu']))
            open
           @endif
        @endif
        ">
        @if (isset($item['submenu']))
            <a href="#" 
               title="{{ is_callable($item['title']) ? $item['title']() : $item['title'] }}">
                <i class="fa fa-lg fa-fw fa-{{$item['icon']}}"></i> 
                <span class="menu-item-parent">{{ is_callable($item['title']) ? $item['title']() : $item['title'] }} </span>
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
@endforeach


