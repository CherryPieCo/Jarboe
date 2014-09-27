
<div class="dd-handle dd3-handle">
    Drag
</div>
<div class="dd3-content">
    {{$item->title}}
    
    <div class="pull-right">
        <button type="button" class="btn btn-default btn-xs" 
                onclick="CatalogBuilder.getEditFormModal(this, '{{$item->id}}','{{$item->title}}','{{$item->slug}}');">
                Редактировать
        </button>
        <button type="button" class="btn btn-default btn-xs" 
                onclick="CatalogBuilder.deleteNestableNode(this, '{{$item->id}}');">
                <i class="fa fa-times"></i>
        </button>
        
    </div>
</div>
