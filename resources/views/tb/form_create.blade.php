<div class="modal-body">
<form id="create_form" class="smart-form" method="post" action="{{$def->getOptions('action_url')}}" novalidate="novalidate">
    
    @if ($def->getPosition()->isEmpty())
        <fieldset style="{{ request()->get('edit') ? '' : 'padding:0;' }}">
            
            @include('admin::tb.modal_form_field_simple')
            
            @if (!$is_blank)
                <input type="hidden" name="id" value="{{ $row->id }}" />
            @endif
        </fieldset>
        
    @else
        <ul class="nav nav-tabs bordered">
            @foreach ($def->getPosition()->get('tabs') as $title => $fields)
                <li @if ($loop->first) class="active" @endif><a href="#tabform-{{$loop->index1}}" data-toggle="tab">{{ $title }}</a></li>
            @endforeach
        </ul>
        <div class="tab-content padding-10">
            @foreach ($def->getPosition()->get('tabs') as $title => $fields)
                <div class="tab-pane @if ($loop->first) active @endif" id="tabform-{{$loop->index1}}">
                    <div class="table-responsive">
                        <fieldset style="padding:0">
                            
                            @include('admin::tb.modal_form_field_tabbed')
                            
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
    <button onclick="jQuery('#create_form').submit();" type="button" class="btn btn-success btn-sm">
        <span class="glyphicon glyphicon-floppy-disk"></span> Save
    </button>
    <button @if (isset($is_page)) onclick="window.history.back();" @endif type="button" class="btn btn-default" data-dismiss="modal">
        Cancel
    </button>
</div>