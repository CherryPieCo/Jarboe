

<tr data-id="{{ $item->id }}">
    <td><a href="?node={{ $item->id }}">{{ $item->title }}</a></td>
    <td>
        <a class="tpl-editable" href="javascript:void(0);" 
            data-type="select" 
            data-name="template" 
            data-pk="{{ $item->id }}" 
            data-value="{{{ $item->template }}}" 
            data-original-title="Выберите шаблон">
                {{{ $item->template }}}
        </a>
    </td>
    
    <td style="white-space: nowrap;">{{ $item->slug }}</td>
    <td>
        <span class="onoffswitch">
            <input onchange="Tree.activeToggle('{{$item->id}}', this.checked);" type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" @if ($item->is_active) checked="checked" @endif id="myonoffswitch{{$item->id}}">
            <label class="onoffswitch-label" for="myonoffswitch{{$item->id}}"> 
                <span class="onoffswitch-inner" data-swchon-text="ДА" data-swchoff-text="НЕТ"></span> 
                <span class="onoffswitch-switch"></span> 
            </label> 
        </span>
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