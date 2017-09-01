<!-- Modal -->
<div class="modal fade tb-modal" id="modal_form_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog {{ $def->getOption('is_form_fullscreen') ? 'tb-modal-fullscreen' : '' }} {{ $def->getOption('form_class') ?: '' }}"  
    @if ($def->getOption('form_width'))
        style="width: {{$def->getOption('form_width')}};" data-width="{{$def->getOption('form_width')}}" 
    @endif
    >

        <div class="form-preloader smoke_lol"><i class="fa fa-gear fa-4x fa-spin"></i></div>

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="modal_form_edit_label">Edit #{{ $row->id }}</h4>
            </div>
            
            @include('admin::tb.form_edit')
            


        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@include('admin::tb.form_edit_validation')