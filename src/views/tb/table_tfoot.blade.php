@if (isset($def['multi_actions']))
<tfoot>
    <tr>
        <td style="vertical-align: middle;">
        <label class="checkbox multi-checkbox multi-main-checkbox" 
               onclick="TableBuilder.doSelectAllMultiCheckboxes(this);">
        <input type="checkbox" /><i></i>
        </label>
        </td>
        
        <td colspan="100%">
            <div class="btn-group">
                @foreach ($def['multi_actions'] as $type => $action)
                <button type="button" class="btn btn-default btn-sm {{ $action['class'] or '' }}" 
                        onclick="TableBuilder.doMultiActionCall('{{$type}}');">
                    {{ $action['caption'] }}
                </button>
                @endforeach
            </div>
        </td>
    </tr>
</tfoot>
@endif