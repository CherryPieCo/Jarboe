@extends('admin::layouts.default')


@section('main')

{{--
            <div class="row show-grid">
                <div id="t" class="bg-color-blueDark  col-xs-4 col-sm-4 col-md-4">
                    @include('admin::tree.tree')
                </div>
                
                <div id="c" class="bg-color-blueLight col-xs-8 col-sm-8 col-md-8">
                    dd
                </div>
            </div>
--}}
          
            <table id="tb-tree-table" class="table table-bordered" data-resizable-columns-id="tb-tree">
                <thead>
                  <tr>
                    <th data-resizable-column-id="tb-tree-controls">@include('admin::tree.tree_controls')</th>
                    <th data-resizable-column-id="editor-controls">sa</th>
                  </tr>
                </thead>
                <tbody>
                 <tr>
                    <td class="tree-td tree-dark" style="vertical-align: top;text-align: left;">@include('admin::tree.tree')</td>
                    <td class="tree-td tree-dark" style="padding: 0px; vertical-align: top;text-align: left;">
                        {{ $content }}
                    </td>
                 </tr>
                </tbody>
            </table>
                      
                      


<link rel="stylesheet" href="/packages/yaro/table-builder/js/plugin/jstree/themes/default/style.min.css" />
<script src="/packages/yaro/table-builder/js/plugin/jstree/jstree.min.js"></script>


<script src="{{ asset('packages/yaro/table-builder/js/plugin/resizableColumns/jquery.resizableColumns.js') }}"></script>
<script src="{{ asset('packages/yaro/table-builder/js/plugin/resizableColumns/store.js') }}"></script>
<link rel="stylesheet" href="{{ asset('packages/yaro/table-builder/js/plugin/resizableColumns/jquery.resizableColumns.css') }}" type="text/css" media="screen" title="no title" charset="utf-8"/>

<script src="{{ asset('packages/yaro/table-builder/tb-tree.js') }}"></script>
<script>
Tree.admin_prefix = '{{ \Config::get('table-builder::admin.uri') }}';
Tree.parent_id = '{{ $current->id }}';
</script>



<style type="text/css" media="screen">

.jstree-default .jstree-themeicon {
    display: none;
}


#tb-ree {
    max-width: 100%;
}
#tb-tree .dd3-handle {
    padding: 1px;
    margin: 2px 0;
}
#tb-tree .dd-list .dd-list {
    padding-left: 22px;
}
#tb-tree .dd3-handle {
    padding: 1px;
    width: 22px;
    margin: 0;
}
#tb-tree .dd3-handle:before {
    line-height: 16px;
}
#tb-tree .dd3-handle:hover:before {
    color: #5AB9E2;
}
#tb-tree .dd-handle:hover, 
#tb-tree .dd-handle:hover+.dd-list .dd-handle {
    background: #B3EFFD !important;
    border: 1px solid #37FAFA;
}
#tb-tree .dd3-item>button {
    margin-left: 22px !important;
}
#tb-tree .dd-item>button {
    margin: 1px 4px;
}
#tb-tree .dd-item>button:before,
#tb-tree .dd-item>button[data-action=collapse]:before {
    color: #A0A0A0;
}
#tb-tree .dd3-content {
    margin: 2px 0;
    padding: 0px 10px 0px 50px;
    font-size: 13px;
    word-break: break-all;
    text-align: left;
}
</style>



@stop

@section('headline')

@stop