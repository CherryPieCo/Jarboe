@foreach ($def->getFields() as $field)
                                     
@if ($field->isHidden() || $field->isReadonly())
    @continue
@endif
                   
@if ($field->isPattern())
    @if ($is_blank)
        {!! $field->renderForm() !!}
    @else
        {!! $field->renderForm($row) !!}
    @endif
    
    @continue
@endif
   
   

@if ($field->getAttribute('tabs'))
    @if ($is_blank)
        {!! $field->getTabbedEditInput() !!}
    @else
        {!! $field->getTabbedEditInput($row) !!}
    @endif
    
    @continue
@endif

@if ($field->getAttribute('type') == 'checkbox')
    @if ($is_blank)
        {!! $field->getEditInput() !!}
    @else
        {!! $field->getEditInput($row) !!}
    @endif
    
    @continue
@endif

<section>
@if ($is_blank)
    <label class="label" for="{{$field->getFieldName()}}">{{$field->getAttribute('caption')}}</label>
    <div style="position: relative;">
        <label class="{{ $field->getLabelClass() }}">
        {!! $field->getEditInput() !!}
        {!! $field->getSubActions() !!}
        </label>
    </div>
@else
    <label class="label" for="{{$field->getFieldName()}}">{{$field->getAttribute('caption')}}</label>
    <div style="position: relative;">
        <label class="{{ $field->getLabelClass() }}">
        {!! $field->getEditInput($row) !!}
        {!! $field->getSubActions() !!}
        </label>
    </div>
@endif
</section>
@endforeach