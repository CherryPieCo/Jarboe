<?php
$colNum = 12 / $divide;
?>
<div class="row">
    @foreach ($options as $option)
    <div class="col col-{{$colNum}}">
        @foreach ($option as $key => $title)
            @if ($link)
            <label class="checkbox" style="float:left;">
                <input type="checkbox" 
                       name="{{$name}}[{{$key}}]" 
                       @if (isset($selected[$key]))
                           checked="checked"
                       @endif
                       >
                <i></i></label>
                <span style="line-height: 25px;">
                    <a href="{{ url($link .'?edit='. $key) }}" target="_blank">{{{$title}}}</a>
                </span>
            @else
            <label class="checkbox">
                <input type="checkbox" 
                       name="{{$name}}[{{$key}}]" 
                       @if (isset($selected[$key]))
                           checked="checked"
                       @endif
                       >
                <i></i>{{{$title}}}</label>
            @endif
        @endforeach
    </div>
    @endforeach
</div>