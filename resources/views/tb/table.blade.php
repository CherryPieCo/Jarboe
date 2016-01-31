<!-- widget grid -->
<section id="widget-grid" class="">

    <!-- row -->
    <div class="row" style="padding-right: 13px; padding-left: 13px;">

        <!-- NEW WIDGET START -->
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-right: 0px; padding-left: 0px;">

            <div id="table-preloader" class="smoke_lol"><i class="fa fa-gear fa-4x fa-spin"></i></div>

            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-1" 
                data-widget-editbutton="false"
                data-widget-colorbutton="false"
                data-widget-deletebutton="false"
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
                    <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                    <h2>{{ $def['options']['caption'] }}</h2>
                    
                    {!! $controller->import->fetch() !!}
                    {!! $controller->export->fetch() !!}
                </header>

                <!-- widget div-->
                <div>

                    <!-- widget edit box -->
                    <div class="jarviswidget-editbox">
                        <!-- This area used as dropdown edit box -->

                    </div>
                    <!-- end widget edit box -->

                    <!-- widget content -->
                    <div class="widget-body no-padding">

<form id="def_options_table_ident" 
      action="{{ $def['options']['action_url'] }}" 
      method="post" 
      class="form-horizontal tb-table"
      target="submiter" >

<table id="datatable_fixed_column" class="table table-bordered table-striped table-hover smart-form dataTable">

    <thead>
        @include('admin::tb.table.thead')
    </thead>

    <tbody>
        @include('admin::tb.table.tbody')
    </tbody>
    
        @include('admin::tb.table.tfoot')

</table> 

@include('admin::tb.table.pagination')

</form> 


                    </div>
                    <!-- end widget content -->
                </div>
                <!-- end widget div -->
            </div>
            <!-- end widget -->
        </article>
        <!-- WIDGET END -->
    </div>
    <!-- end row -->
</section>
<!-- end widget grid -->   
