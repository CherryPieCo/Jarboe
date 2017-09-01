

<tr data-id="{{ $item->id }}">
    <td><a href="?node={{ $item->id }}">{{ $item->title }}</a></td>
    <td>
        <a class="tpl-editable" href="javascript:void(0);" 
            @if (!isset($current->getTemplates()[$item->template]['caption'])) style="color:red;" @endif
            data-type="select" 
            data-name="template" 
            data-pk="{{ $item->id }}" 
            data-value="{{ $item->template }}" 
            data-original-title="Choose template">
                {{ /* FIXME: */ isset($current->getTemplates()[$item->template]['caption']) ? $current->getTemplates()[$item->template]['caption'] : 'missing template' }}
        </a>
    </td>
    
    <td style="white-space: nowrap;">{{ $item->slug }}</td>
    <td style="position: relative;">
        @if ($current->getNodeActiveFieldOptions())
            <div class="node-active-smoke-lol" style="display:none; position: absolute; width: 100%; height: 100%; top: 0; background: #E5E5E5; left: 0px; z-index: 69; opacity: 0.6;"></div>
            <table>
            <tbody>
                <?php foreach($current->getNodeActiveFieldOptions() as $setIdent => $caption): ?>
                    <tr style="white-space: nowrap;">
                    <td>
                        <span class="">
                            {{$caption}}: 
                        </span>
                    </td>
                    <td>
                        <span class="onoffswitch">
                            <input onchange="Tree.activeSetToggle(this, '{{$item->id}}');" type="checkbox" name="onoffswitch[{{$setIdent}}]" 
                                    class="onoffswitch-checkbox" 
                                    {!! $item->isActive($setIdent) ? 'checked="checked"' : '' !!} 
                                    id="myonoffswitch{{$item->id}}-{{$setIdent}}">
                            <label class="onoffswitch-label" for="myonoffswitch{{$item->id}}-{{$setIdent}}"> 
                                <span class="onoffswitch-inner" data-swchon-text="YES" data-swchoff-text="NO"></span> 
                                <span class="onoffswitch-switch"></span> 
                            </label> 
                        </span>
                    </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            </table>
        @else
            <span class="onoffswitch" style="margin: 0;">
                <input onchange="Tree.activeToggle('{{$item->id}}', this.checked);" type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" @if ($item->is_active) checked="checked" @endif id="myonoffswitch{{$item->id}}">
                <label class="onoffswitch-label" for="myonoffswitch{{$item->id}}"> 
                    <span class="onoffswitch-inner" data-swchon-text="YES" data-swchoff-text="NO"></span> 
                    <span class="onoffswitch-switch"></span> 
                </label> 
            </span>
        @endif
    </td>
    <td>
        <a class="btn btn-default btn-sm" href="{{ url($item->getUrl()) }}?show=1" target="_blank">
            <i class="fa fa-eye"></i>
        </a>
        <a onclick="Tree.showEditForm('{{ $item->id }}');" class="btn btn-default btn-sm" href="javascript:void(0);">
            <i class="fa fa-pencil"></i>
        </a>
        <a onclick="Tree.doDelete('{{ $item->id }}', this);" class="node-del-{{$item->id}} btn btn-default btn-sm" href="javascript:void(0);">
            <i class="fa fa-times"></i>
        </a>
    </td>
</tr>