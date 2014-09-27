
<ol class="dd-list">
@foreach($item->children()->get() as $child)

    @if ($child->children()->count())
        <li class="dd-item dd3-item" data-id="{{$child->id}}" data-parent-id="{{$child->parent_id}}">
            <div class="dd-handle dd3-handle">
                Drag
            </div>
            <div class="dd3-content">
                {{$child->title}}
                
                <div class="pull-right">
                    <button type="button" class="btn btn-default btn-xs" 
                            onclick="CatalogBuilder.getEditFormModal(this, '{{$child->id}}','{{$child->title}}','{{$child->slug}}');">
                            Редактировать
                    </button>
                    <button type="button" class="btn btn-default btn-xs" 
                            onclick="CatalogBuilder.deleteNestableNode(this, '{{$child->id}}');">
                            <i class="fa fa-times"></i>
                    </button>
                </div>
            </div>
            
            @include('admin::catalog.row_children', array('item' => $child))
        </li>
    @else
        <li class="dd-item dd3-item" data-id="{{$child->id}}" data-parent-id="{{$child->parent_id}}">
            @include('admin::catalog.row', array('item' => $child))
        </li>
    @endif
    
@endforeach
</ol>

