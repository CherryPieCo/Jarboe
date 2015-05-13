<tr>
    <td>{{ $tag->id }}</td>
    <td>{{ $tag->title }}</td>
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