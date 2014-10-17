
<div class="widget-toolbar" role="menu">
    <!-- add: non-hidden - to disable auto hide -->

    <div class="btn-group">
    
    <button class="btn dropdown-toggle btn-xs btn-default" data-toggle="dropdown">
        <i class="fa fa-download"></i>
        {{ $def['caption'] or 'Export' }}
    </button>
    
    <ul class="dropdown-menu pull-right" style="min-width: {{ $def['width'] or '260' }}px; padding-bottom: 0;">
        
        <form id="tb-export-form" class="smart-form">
            <fieldset style="padding: 12px 12px 0;">
            <section>
                <div class="row">
                    <div class="col col-12">
                        @foreach ($fields as $field)
                        <label class="checkbox">
                            <input type="checkbox" name="b[{{ $field->getFieldName() }}]">
                            <i></i>
                            {{ $field->getAttribute('caption') }}
                        </label>
                        @endforeach
                    </div>
                </div>
            </section>
            </fieldset>
        </form>
        
        <div class="btn-group btn-group-justified">
            @foreach ($def['buttons'] as $type => $info)
                <a href="javascript:void(0);" 
                   onclick="TableBuilder.doExport('{{ $type }}');" 
                   class="btn btn-default">
                        {{ $info['caption'] }}
                </a>
            @endforeach
        </div>
        
    </ul>
    
    </div>
</div>

<script type="text/javascript">
    jQuery('#tb-export-form').bind('click', function(e) { 
        e.stopPropagation() 
    });
</script>
