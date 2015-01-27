<div class="tb-tree-content-inner">
    

@if ($current->hasTableDefinition())
    
{{ $table }}
<div id="modal_wrapper"></div>
{{ $form }}


@else

<div>
<table class="table table-bordered">
    <thead></thead>
    <tbody>
    @foreach($current['children'] as $item)
    <tr><td>{{$item->title}}</td></tr>
    @endforeach
    </tbody>
</table>
</div>

@endif
    
</div>