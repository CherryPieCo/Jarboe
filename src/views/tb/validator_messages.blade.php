
@if ($tabs)
    @foreach ($tabs as $tab)
        '{{ $name . $tab['postfix'] }}' : {
        
        @foreach ($messages as $rule => $message)
            
            {{$rule}} : '{{$message}}',
            
        @endforeach
        
        },
    @endforeach
@else
    '{{$name}}' : {
        
    @foreach ($messages as $rule => $message)
        
        {{$rule}} : '{{$message}}',
        
    @endforeach
    
    },
@endif