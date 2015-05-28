<section id="widget-grid" class="resizable-structure" style="margin: 0;">

    <!-- row -->
    <div class="row" style="margin-right: 0; margin-left: 0;">

<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0px;">
<div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-3" style="margin: 0;"
                data-widget-editbutton="false"
                data-widget-colorbutton="false"
                data-widget-deletebutton="false"
                data-widget-togglebutton="false"
                data-widget-sortable="false">
                <!-- widget options:
                usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">

                data-widget-colorbutton="false"
                data-widget-editbutton="false"
                data-widget-togglebutton="false"
                data-widget-deletebutton="false"
                data-widget-fullscreenbutton="false"
                data-widget-custombutton="false"
                data-widget-collapsed="true"
                data-widget-sortable="false"

                -->

            

                <header>
                    <div style="margin-right: 34px;">
                        <input type="text" id="plugins4_q" value="" class="input" style="line-height: 20px; display:block; padding:4px; border-radius:4px; border:1px solid silver;width: 100%;height: 28px;margin: 2px;">
                    </div>
                </header>

                <!-- widget div-->
                <div>

                    <!-- widget edit box -->
                    <div class="jarviswidget-editbox">
                        <!-- This area used as dropdown edit box -->

                    </div>
                    <!-- end widget edit box -->

                    <!-- widget content -->
                    <div class="widget-body no-padding" style="padding-right: 6px !important;">






<style type="text/css" media="screen">
.tb-tree-content-inner .table-bordered>tbody>tr>td {
    text-align: left;
}
</style>

<style type="text/css">

</style>


<div id="tb-tree" class="demo">
    <ul>
        @foreach($tree as $item)
        <li data-jstree='{ "opened" : true }'  data-id="{{$item->id}}" data-parent-id="{{$item->parent_id}}">
            @if ($item->children()->count())
                {{ $item->title }}
                @include('admin::tree.node_children', $item)
                
            @else
                @include('admin::tree.node', $item)
            @endif
        </li>
        @endforeach
    </ul>
</div>


@include('admin::tree.create_modal')




</div></div></div></article></div></section>
