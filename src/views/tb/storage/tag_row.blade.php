<tr>
    <td>{{ $tag->title }}</td>
    <td width="1%">
        <a href="javascript:void(0);" class="btn btn-default btn-sm" 
           onclick="Superbox.deleteTag({{ $tag->id }}, this);">
            <i class="fa fa-times"></i>
        </a>
    </td>
</tr>