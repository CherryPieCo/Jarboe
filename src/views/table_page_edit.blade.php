@extends('admin::layouts.default')


@section('headline')
<div class="well" style="padding: 10px;">
<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <a href="javascript:void(0);" onclick="window.history.back();" class="btn btn-default">Назад</a>
    <a href="{{ url($definition['db']['pagination']['uri']) }}" class="btn btn-info">К таблице</a>
</div>
</div>
</div>
@stop



@section('main')

<section>
<div class="row">
    <article class="col-sm-12 ">
        <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-x22" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-custombutton="false" data-widget-sortable="false" role="widget" style="">
            <header role="heading">
                <span class="widget-icon"> <i class="fa fa-align-justify"></i> </span>
                <h2>Редактирование #{{{$id}}} </h2>
            <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span></header>
            <!-- widget div-->
            <div role="content">
                <!-- widget edit box -->
                <div class="jarviswidget-editbox">
                </div>
                <!-- end widget edit box -->

                <!-- widget content -->
                <div class="widget-body">
                    <div class="table-page">
                    {{ $form }}
                    
                    {{ $js }}
                    </div>
                </div>
            </div>
        </div>
    </article>
</div>
</section>




<style>
.table-page {
    margin: -25px;
}
.table-page .modal-footer {

}
</style>

<script>

//jQuery(document).ready(function() {
    TableBuilder.init({
        ident: '{{ $definition['options']['ident'] }}',
        table_ident: '{{ $definition['options']['table_ident'] }}',
        form_ident: '{{ $definition['options']['form_ident'] }}',
        action_url: '{{ $definition['options']['action_url'] }}',
        list_url: '{{ $definition['db']['pagination']['uri'] }}',
        is_page_form: true,
        onSearchResponse: function() {
            //Dashboard.initTooltips();
        },
    });
    TableBuilder.admin_prefix = '{{ $definition['options']['admin_uri'] }}';
//});


jQuery(document).ready(function() {
    jQuery(TableBuilder.form_edit).find('input[data-mask]').each(function() {
        var $input = jQuery(this);
        $input.mask($input.attr('data-mask'));
    });
    
    TableBuilder.initSingleImageEditable();
    TableBuilder.initMultipleImageEditable();
    TableBuilder.initSummernoteFullscreen();
    TableBuilder.initSelect2Hider();
    
    if (TableBuilder.afterGetEditForm) {
        TableBuilder.afterGetEditForm();
    }
});
</script>
@stop