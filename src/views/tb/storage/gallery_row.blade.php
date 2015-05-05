<tr>
    <td>{{ $gallery->title }}</td>
    <td width="1%">
        <a href="javascript:void(0);" class="btn btn-default btn-sm" 
           onclick="Superbox.deleteGallery({{ $gallery->id }}, this);">
            <i class="fa fa-times"></i>
        </a>
    </td>
</tr>