
<div class="tb-tree-content-inner">
    

@if ($current->hasTableDefinition())

    @section('table_form')
        {{ $form }}
    @stop
    
    {{ $table }}
    
@else


    <div class="smart-form">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>название</th>
                <th width="1%">шаблон</th>
                <th width="1%">слаг</th>
                <th width="1%">активный</th>
                <th style="width: 1%; min-width: 105px;">
                    <a href="javascript:void(0);" onclick="Tree.showCreateForm('{{$current->id}}');" style="min-width: 70px;" class="btn btn-default btn-sm">создать</a>
                </th>
            </tr>
        </thead>

        <tbody>

        @if ($current->id == 1)
            <?php $current->children->prepend($current); ?>
        @endif

        @foreach($current['children'] as $item)
            @include('admin::tree.content_row')
        @endforeach

        </tbody>

        <tfoot>
        </tfoot>

    </table>
    </div>
    
    
    <style>
        .smart-form .popover-title {
            margin: 0;
            padding: 8px 14px;
        }
        .smart-form .popover-content {
            padding: 9px 14px;
        }
        .smart-form .editable-buttons {
            margin-left: 7px;
        }
    </style>
    <script>
    // FIXME: move to js file
        $(document).ready(function(){
            $('.tpl-editable').editable({
                url: window.location.href,
                source: [
                <?php /* FIXME: */ $tpls = \Config::get('jarboe::tree.templates', array()); ?>
                @foreach ($tpls as $capt => $tpl)
                    { value: '{{{$capt}}}', text: '{{{$capt}}}' }, 
                @endforeach
                ],
                display: function(value, response) {
                    return false;   //disable this method
                },
                success: function(response, newValue) {
                    $(this).html('$' + newValue);
                },
                params: function(params) {
                    //originally params contain pk, name and value
                    params.query_type = 'do_update_node';
                    return params;
                }
            });
        });
    </script>

@endif
    
</div>