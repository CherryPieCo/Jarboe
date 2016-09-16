
<script>
jQuery(document).ready(function() {
    var $validator = jQuery("#edit_form").validate({
        rules: {
            @foreach ($def->getFields() as $field)
                @if ($field->isPattern())
                    @continue
                @endif
                
                {!! $field->getClientsideValidatorRules() !!}
            @endforeach
        },
        messages: {
            @foreach ($def->getFields() as $field)
                @if ($field->isPattern())
                    @continue
                @endif
                
                {!! $field->getClientsideValidatorMessages() !!}
            @endforeach
        },
        submitHandler: function(form) {   
            console.log('ok?edit');                     
            {{ $is_tree ? 'Tree' : 'TableBuilder' }}.doEdit({{$row->id}});
        }
    });
});   
</script>
