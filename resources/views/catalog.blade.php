@extends('admin::layouts.default')

@section('main')
    <section>
        <!-- row -->
        <div class="row">
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">
            
            <div class="dd" id="nestable3">
                <ol class="dd-list">
                @foreach($content as $item)
                    
                    
                    <li class="dd-item dd3-item" data-id="{{$item->id}}" data-parent-id="{{$item->parent_id}}">
                    @if ($item->children()->count())
                    
                        <div class="dd-handle dd3-handle">Drag</div>
                        <div class="dd3-content">
                            {{$item->title}}
                            
                            <div class="pull-right">
                                <button type="button" class="btn btn-default btn-xs" 
                                        onclick="CatalogBuilder.getEditFormModal(this, '{{$item->id}}','{{$item->title}}','{{$item->slug}}');">
                                        Редактировать
                                </button>
                            </div>
                        </div>
                            
                        @include('admin::catalog.row_children', $item)
                        
                        
                    @else
                        @include('admin::catalog.row', $item)
                    @endif
                    </li>
                    
                @endforeach
                </ol>
            </div>    
            
        </article>
        </div>
    </section>
@stop

@section('headline')
<div class="row hidden-mobile">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <h1 class="page-title txt-color-blueDark">
            Управление каталогом
        </h1>
    </div>
    
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-align-right">
        <div class="page-title">
            <button class="btn btn-primary" data-toggle="modal" data-target="#addCatalogModal">
                Добавить
            </button>
        </div>
    </div>
</div>



<!-- Modal catalog add -->
<div class="modal fade" id="addCatalogModal" tabindex="-1" role="dialog" aria-labelledby="addCatalogModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    ×
                </button>
                <h4 class="modal-title" id="addCatalogModalLabel">Добавить в каталог</h4>
            </div>
            <div class="modal-body">
                <form id="catalog-add-form" method="post" action="/admin/catalog/add" class="smart-form">
                <div class="row">
                    <div class="col-md-12">
                        
                        <fieldset style="padding-top: 0;">
                            <section>
                                <label class="label">Название каталога</label>
                                <label for="title" class="input">
                                    <input type="text" id="title" name="title" class="form-control" placeholder="Название" required="">
                                </label>
                            </section>
                            
                            <section>
                                <label class="label">Слаг каталога (uri)</label>
                                <label for="slug" class="input">
                                    <input type="text" id="slug" name="slug" class="form-control" placeholder="slug" required="">
                                </label>
                            </section>
                        </fieldset>
                        
                    </div>
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="jQuery('#catalog-add-form').submit();">
                    Добавить
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    Отмена
                </button>
            </div>
            
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!-- Modal catalog edit -->
<div class="modal fade" id="editCatalogModal" tabindex="-1" role="dialog" aria-labelledby="editCatalogModalLabel" aria-hidden="true" style="display: none;">
    
</div>
@stop

@section('scripts')
<script src="{{asset('packages/yaro/jarboe/catalog-builder.js')}}"></script>

<script>
    //CatalogBuilder.segment = '';
</script>
@stop





