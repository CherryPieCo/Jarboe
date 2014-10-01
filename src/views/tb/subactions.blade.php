
<div class="dropdown subactions">
    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-lg fa-gear"></i> 
    </a>
    <ul class="dropdown-menu">
        @foreach ($subactions as $sub)
        <li>
            <a href="#l3" data-toggle="tab">{{$sub['caption']}}</a>
        </li>
        @endforeach
    </ul>
</div>

