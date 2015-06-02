<tr>
    <td>{{ $tag->id }}</td>
    <td>
        <div class="b-value">
            <a onclick="Superbox.showTagEditInput(this);" style="text-decoration: blink; border-bottom: rgb(153, 153, 153) 1px dotted; color: black;" href="javascript:void(0);">
                {{ $tag->title }}
            </a>
        </div>
        <div class="b-input" style="display: none;">
            <input type="text" value="{{ $tag->title }}">
            <a onclick="Superbox.saveTagEditInput(this, '{{ $tag->id }}');" href="javascript:void(0);" class="btn btn-default btn-sm" style="height: 24px;line-height: 8px;margin-top: -4px;">
                <i class="fa fa-check"></i>
            </a>
            <a onclick="Superbox.closeTagEditInput(this);" href="javascript:void(0);" class="btn btn-default btn-sm" style="height: 24px;line-height: 8px;margin-top: -4px;">
                <i class="fa fa-times"></i>
            </a>
        </div>
    </td>
    @if ($type == 'tag')
    <td width="1%">
        <a href="javascript:void(0);" class="btn btn-default btn-sm" 
           onclick="Superbox.selectTag(this, {{ $tag->id }});">
            Выбрать
        </a>
    </td>
    @endif
    <td width="1%">
        <a href="javascript:void(0);" class="btn btn-default btn-sm" 
           onclick="Superbox.deleteTag({{ $tag->id }}, this);">
            <i class="fa fa-times"></i>
        </a>
    </td>
</tr>