<div id="def_options_ident" class="widget-box table-builder dataTables_wrapper">
    {{--
    <div class="widget-title">
        <span class="icon">
            <i class="glyphicon glyphicon-th"></i>
        </span>
        <h5>{{ $def['options']['caption'] }}</h5>
    </div>
    --}}
        @include('admin::tb.form')
        @include('admin::tb.table')
        
        @include('admin::tb.table.ui_overlay')

        <iframe id="submiter" name="submiter" style="display:none; visibility:hidden;"></iframe>                    
    </div>



</div>

<script type="text/javascript">
TableBuilder.init({!! json_encode($def->getOptions()) !!});
TableBuilder.admin_prefix = '{{ config('jarboe.admin.uri') }}';
</script>
