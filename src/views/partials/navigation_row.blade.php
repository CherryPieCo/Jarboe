<a href="{{url(Config::get('admin.uri') . $item['link'])}}">
    @if (isset($item['icon']))
        <i class="fa fa-lg fa-fw fa-{{$item['icon']}}"></i> 
    @endif
    <span class="menu-item-parent">{{$item['title']}}</span>
</a>