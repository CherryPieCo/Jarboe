<div class="modal-body">
                
                
    <form id="edit_form" class="smart-form">
    
        @if ($def->getPosition()->isEmpty())
            <fieldset style="{{ request()->get('edit') ? '' : 'padding:0;' }}">
            
            @include('admin::tb.modal_form_edit_field_simple')
            
            @if (!$is_blank)
                <input type="hidden" name="id" value="{{ $row->id }}" />
            @endif
            </fieldset>
        
        @else
            
            <ul class="nav nav-tabs bordered">
                @foreach ($def->getPosition()->get('tabs') as $title => $fields)
                    <li @if ($loop->first) class="active" @endif><a href="#etabform-{{$loop->index1}}" data-toggle="tab">{{ $title }}</a></li>
                @endforeach
            </ul>
            <div class="tab-content padding-10">
                @foreach ($def->getPosition()->get('tabs') as $title => $fields)
                    <div class="tab-pane @if ($loop->first) active @endif" id="etabform-{{$loop->index1}}">
                        <div class="table-responsive">
                            <fieldset style="padding:0">
                                
                                @include('admin::tb.modal_form_edit_field_tabbed')
                                
                                @if (!$is_blank)
                                    <input type="hidden" name="id" value="{{ $row->id }}" />
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
    <a onclick="jQuery('#edit_form').submit();" href="javascript:void(0);" class="btn btn-success btn-sm">
        <span class="glyphicon glyphicon-floppy-disk"></span> Save
    </a>
    <a @if (isset($is_page)) onclick="window.history.back();" @endif href="javascript:void(0);" class="btn btn-default" data-dismiss="modal">
        Cancel
    </a>
</div>