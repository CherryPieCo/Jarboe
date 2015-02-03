@if (isset($def['multi_actions']))
<tfoot>
    <tr>
        @if (isset($def['options']['is_sortable']) && $def['options']['is_sortable'])
            <td style="width: 1%; padding: 14px 0 0 0;">
                <i style="padding-left: 8px;" class="fa fa-reorder"></i>
            </td>
        @endif
        
        <td style="vertical-align: middle;">
        <label class="checkbox multi-checkbox multi-main-checkbox" 
               onclick="TableBuilder.doSelectAllMultiCheckboxes(this);">
        <input type="checkbox" /><i></i>
        </label>
        </td>
        
        <td colspan="100%">
            <div class="btn-group">
                @foreach ($def['multi_actions'] as $type => $action)
                @if (!isset($action['options']))
                <button type="button" class="btn btn-default btn-sm {{ $action['class'] or '' }}" 
                        onclick="TableBuilder.doMultiActionCall('{{$type}}');">
                    {{ $action['caption'] }}
                </button>
                @endif
                @endforeach
            </div>
            
            @foreach ($def['multi_actions'] as $type => $action)
            @if (isset($action['options']))
                <div class="btn-group dropup">
                    <button class="btn btn-default btn-sm dropdown-toggle {{ $action['class'] or '' }}" data-toggle="dropdown">
                        {{ $action['caption'] }} <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <?php $actionOptions = $action['options'](); ?>
                        @foreach ($actionOptions as $subActionID => $subActionTitle)
                        <li>
                            <a onclick="TableBuilder.doMultiActionCallWithOption(this, '{{$type}}', '{{$subActionID}}');" href="javascript:void(0);">{{ $subActionTitle }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @endforeach
            
        </td>
    </tr>
</tfoot>

<script>
jQuery(document).ready(function() {
    jQuery('.dropdown-toggle').dropdown();
});
</script>

@endif