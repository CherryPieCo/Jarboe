
<div class="widget-toolbar" role="menu">
    <!-- add: non-hidden - to disable auto hide -->

    <div class="btn-group">
    
    <button class="btn dropdown-toggle btn-xs btn-default" data-toggle="dropdown">
        <i class="fa fa-download"></i>
        {{ $def['caption'] or 'Import' }}
    </button>
    
    <ul class="dropdown-menu pull-right" style="min-width: {{ $def['width'] or '260' }}px; padding-bottom: 0;">
        
        <form id="tb-import-form" class="smart-form">
            <fieldset style="padding: 12px 12px 0;">
                @foreach ($def['files'] as $type => $info)
                <section>
                    <div class="row">
                        <div class="col col-12" style="width: 100%;">
                            <label class="label">{{ $info['caption'] }} (<a onclick="TableBuilder.doDownloadImportTemplate('{{ $type }}');" href="javascript:void(0);">скачать шаблон</a>)</label>
                            <div class="input input-file">
                                <span class="button" style="top: 3px; right: 3px;">
                                    <input type="file" name="file" onclick="this.value = null;" onchange="TableBuilder.doImport(this, '{{ $type }}');">
                                    Выбрать
                                </span>
                                <input type="text" placeholder="{{ $info['caption'] }}" readonly="readonly">
                            </div>
                        </div>
                    </div>
                </section>
                @endforeach
            </fieldset>
        </form>
        
    </ul>
    
    </div>
</div>

<script type="text/javascript">
jQuery('#tb-import-form').bind('click', function(e) { 
    e.stopPropagation() 
});
</script>
