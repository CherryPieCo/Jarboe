@extends('admin::layouts.default')


@section('main')

<div class="row">
    <div class="table-page">
    {{ $form }}
    
    {{ $js }}
    </div>
</div>

<style>
.table-page .tab-content,
.table-page .modal-footer {
    background: rgba(255,255,255,.9);
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