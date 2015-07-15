<label class="checkbox">
<input type="checkbox" 
       id="{{$name}}"
       name="{{ $name }}" 
       @if ($value) 
           checked="checked" 
       @endif
       >
<i></i>{{$caption}}</label>