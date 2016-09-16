
@foreach ($fields as $ident)
<?php 
// for input sizes
$size = '';
if (is_array($ident)) {
    $idents = $ident;
    $size = 12 / count($idents);
} else {
    $idents = [$ident];
}
?>
<div class="tb-form-row">
@foreach ($idents as $ident)
<?php
$field = $controller->getDefinition()->getField($ident); 
?>


@if ($field->isHidden())
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

<section class="{{ $size ? 'col col-'. $size : '' }}" >
@if ($is_blank)
    <label class="label" for="{{$ident}}">{{$field->getAttribute('caption')}}</label>
    <div style="position: relative;">
        <label class="{{ $field->getLabelClass() }}">
        {!! $field->getEditInput() !!}
        {!! $field->getSubActions() !!}
        </label>
    </div>
@else
    <label class="label" for="{{$ident}}">{{$field->getAttribute('caption')}}</label>
    <div style="position: relative;">
        <label class="{{ $field->getLabelClass() }}">
        {!! $field->getEditInput($row) !!}
        {!! $field->getSubActions() !!}
        </label>
    </div>
@endif
</section>

@endforeach
</div>
@endforeach
