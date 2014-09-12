
@if ($tabs)

    @foreach ($tabs as $tab)
        '{{ $name . $tab['postfix'] }}' : {
            
        @foreach ($rules as $rule => $option)
            
            @if ($option === true)
                {{$rule}} : true,
            @else
                {{$rule}} : '{{$option}}',
            @endif
            
        @endforeach
        
        },
    @endforeach
    
@else

    '{{$name}}' : {
        
    @foreach ($rules as $rule => $option)
        
        @if ($option === true)
            {{$rule}} : true,
        @else
            {{$rule}} : '{{$option}}',
        @endif
        
    @endforeach
    
    },

@endif