<!-- Modal -->
<div class="modal fade tb-modal" id="modal_form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
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
                <h4 class="modal-title" id="modal_form_label">Создание</h4>
            </div>
            
            <div class="modal-body">
            <form id="create_form" class="smart-form" method="post" action="{{$def['options']['action_url']}}" novalidate="novalidate">
                
                @if (!isset($def['position']))
                    <fieldset style="padding:0">
                        
                        @include('admin::tb.modal_form_field_simple')
                        
                        @if (!$is_blank)
                            <input type="hidden" name="id" value="{{ $row['id'] }}" />
                        @endif
                    </fieldset>
                    
                @else
                    <ul class="nav nav-tabs bordered">
                        @foreach ($def['position']['tabs'] as $title => $fields)
                            <li @if ($loop->first) class="active" @endif><a href="#tabform-{{$loop->index1}}" data-toggle="tab">{{ $title }}</a></li>
                        @endforeach
                    </ul>
                    <div class="tab-content padding-10">
                        @foreach ($def['position']['tabs'] as $title => $fields)
                            <div class="tab-pane @if ($loop->first) active @endif" id="tabform-{{$loop->index1}}">
                                <div class="table-responsive">
                                    <fieldset style="padding:0">
                                        
                                        @include('admin::tb.modal_form_field_tabbed')
                                        
                                        @if (!$is_blank)
                                            <input type="hidden" name="id" value="{{ $row['id'] }}" />
                                        @endif
                                    </fieldset>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
                
            </form>
            </div>

            <div class="modal-footer">
                <button onclick="jQuery('#create_form').submit();" type="button" class="btn btn-success btn-sm">
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
    var $validator = jQuery("#create_form").validate({
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
            console.log('ok?');                     
            TableBuilder.doCreate();
        }
    });
});   
</script>
