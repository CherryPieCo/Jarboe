
<style type="text/css" media="screen">
.tb-tree-content-inner td {
    text-align: left;
}
</style>


<div id="tb-tree" class="demo">
    <ul>
        @foreach($tree as $item)
        <li data-jstree='{ "opened" : true, "icon":"http://cdn-img.easyicon.net/png/5359/535943.png" }'  data-id="{{$item->id}}" data-parent-id="{{$item->parent_id}}">
            @if ($item->children()->count())
                {{$item->title}}
                @include('admin::tree.node_children', $item)
                
            @else
                @include('admin::tree.node', $item)
            @endif
        </li>
        @endforeach
    </ul>
</div>



<?php /*
<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable" style="padding: 0;overflow: hidden !important;">
    

    
    <div class="dd" id="tb-tree">
        <ol class="dd-list">
        @foreach($tree as $item)
            
            
            <li class="dd-item dd3-item" data-id="{{$item->id}}" data-parent-id="{{$item->parent_id}}">
            @if ($item->children()->count())
            
                <div class="dd-handle dd3-handle">Drag</div>
                <div class="dd3-content">
                    {{$item->title}}
                    {{--
                    <div class="pull-right">
                        <button type="button" class="btn btn-default btn-xs" 
                                onclick="CatalogBuilder.getEditFormModal(this, '{{$item->id}}','{{$item->title}}','{{$item->slug}}');">
                                Редактировать
                        </button>
                    </div>
                    --}}
                </div>
                    
                @include('admin::tree.node_children', $item)
                
                
            @else
                @include('admin::tree.node', $item)
            @endif
            </li>
            
        @endforeach
        </ol>
    </div>    
    
</article>

*/ ?>