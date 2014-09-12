<?php
$colNum = 12 / $divide;
?>
<div class="row">
    @foreach ($options as $option)
    <div class="col col-{{$colNum}}">
        @foreach ($option as $key => $title)
        <label class="checkbox">
            <input type="checkbox" 
                   name="{{$name}}[{{$key}}]" 
                   @if (isset($selected[$key]))
                       checked="checked"
                   @endif
                   >
            <i></i>{{$title}}</label>
        @endforeach
    </div>
    @endforeach
</div>