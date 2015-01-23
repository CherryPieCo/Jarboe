
@foreach ($fields as $ident)
<?php 
$options = $def['fields'][$ident];
$field = $controller->getField($ident); 
?>

@if ($field->isPattern())
    @if ($is_blank)
        {{ $field->render() }}
    @else
        {{ $field->render($row) }}
    @endif
    
    @continue
@endif


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
        {{ $field->getSubActions() }}
        </label>
    </div>
@else
    <label class="label" for="{{$ident}}">{{$options['caption']}}</label>
    <div style="position: relative;">
        <label class="{{ $field->getLabelClass() }}">
        {{ $field->getEditInput($row) }}
        {{ $field->getSubActions() }}
        </label>
    </div>
@endif
</section>

@endforeach