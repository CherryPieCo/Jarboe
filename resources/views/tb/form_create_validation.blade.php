<script>
jQuery(document).ready(function() {
    var $validator = jQuery("#create_form").validate({
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
            console.log('ok?');                     
            TableBuilder.doCreate();
        }
    });
});   
</script>