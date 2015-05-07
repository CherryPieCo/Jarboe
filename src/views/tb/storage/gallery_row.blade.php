<tr>
    <td>{{ $gallery->id }}</td>
    <td>{{ $gallery->title }}</td>
    @if ($type == 'gallery')
    <td width="1%">
        <a href="javascript:void(0);" class="btn btn-default btn-sm" 
           onclick="Superbox.selectGallery(this, {{ $gallery->id }});">
            Выбрать
        </a>
    </td>
    @endif
    <td width="1%">
        <a href="javascript:void(0);" class="btn btn-default btn-sm" 
           onclick="Superbox.deleteGallery({{ $gallery->id }}, this);">
            <i class="fa fa-times"></i>
        </a>
    </td>
</tr>