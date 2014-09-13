<!-- Modal -->
<div class="modal fade" id="modal_form_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog <?php echo isset($def['options']['is_form_fullscreen']) ? 'tb-modal-fullscreen' : '';?>" 
    @if (isset($def['options']['form_width']))
        style="width: {{$def['options']['form_width']}};"
    @endif
    >

        <div class="form-preloader smoke_lol"><i class="fa fa-gear fa-4x fa-spin"></i></div>

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="modal_form_edit_label">Редактирование</h4>
            </div>
            
            <div class="modal-body">
                <form id="edit_form" class="smart-form">
                    <fieldset style="padding:0">

                    @foreach ($def['fields'] as $ident => $options)
                        <?php $field = $controller->getField($ident); ?>
                        @if ($field->isHidden())
                            @continue
                        @endif
                        
                        @if (isset($options['tabs']))
                            @if ($is_blank)
                                {{ $field->getTabbedEditInput() }}
                            @else
                                {{ $field->getTabbedEditInput($row) }}
                            @endif
                            
                            @continue
                        @endif
                        
                        @if ($options['type'] == 'checkbox')
                            @if ($is_blank)
                                {{ $field->getEditInput() }}
                            @else
                                {{ $field->getEditInput($row) }}
                            @endif
                            
                            @continue
                        @endif
                        
                        <section>
                        @if ($is_blank)
                            <label class="label" for="{{$ident}}">{{$options['caption']}}</label>
                            <div style="position: relative;">
                                <label class="{{ $field->getLabelClass() }}">
                                {{ $field->getEditInput() }}
                                </label>
                            </div>
                        @else
                            <label class="label" for="{{$ident}}">{{$options['caption']}}</label>
                            <div style="position: relative;">
                                <label class="{{ $field->getLabelClass() }}">
                                {{ $field->getEditInput($row) }}
                                </label>
                            </div>
                        @endif
                        </section>
                    @endforeach
                    
                    @if (!$is_blank)
                        <input type="hidden" name="id" value="{{ $row['id'] }}" />
                    @endif

                    </fieldset>
                </form>
            </div>

            <div class="modal-footer">
                <button onclick="jQuery('#edit_form').submit();" type="button" class="btn btn-success btn-sm">
                    <span class="glyphicon glyphicon-floppy-disk"></span> Сохранить
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    Отмена
                </button>
            </div>


        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script>
jQuery(document).ready(function() {
    var $validator = jQuery("#edit_form").validate({
        rules: {
            @foreach ($def['fields'] as $ident => $options)
                <?php $field = $controller->getField($ident); ?>
                
                {{ $field->getClientsideValidatorRules() }}
            @endforeach
        },
        messages: {
            @foreach ($def['fields'] as $ident => $options)
                <?php $field = $controller->getField($ident); ?>
                
                {{ $field->getClientsideValidatorMessages() }}
            @endforeach
        },
        submitHandler: function(form) {   
            console.log('ok?edit');                     
            TableBuilder.doEdit({{$row['id']}});
        }
    });
});   
</script>
