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