<input type="text" 
       id="{{$name}}"
       value="{{{ $value }}}" 
       name="{{ $name }}" 
       placeholder="{{{ $placeholder }}}"
       @if ($mask)
         data-mask="{{$mask}}"
       @endif
       class="dblclick-edit-input form-control input-sm unselectable">
</input>