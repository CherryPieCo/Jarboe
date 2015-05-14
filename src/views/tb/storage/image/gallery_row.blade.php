<tr>
    <td>{{ $gallery->id }}</td>
    <td>
        <div class="b-value">
            <a onclick="Superbox.showGalleryEditInput(this);" style="text-decoration: blink; border-bottom: rgb(153, 153, 153) 2px dotted; color: black;" href="javascript:void(0);">
                {{ $gallery->title }}
            </a>
        </div>
        <div class="b-input" style="display: none;">
            <input type="text" value="{{ $gallery->title }}">
            <a onclick="Superbox.saveGalleryEditInput(this, '{{ $gallery->id }}');" href="javascript:void(0);" class="btn btn-default btn-sm" style="height: 24px;line-height: 8px;margin-top: -4px;">
                <i class="fa fa-check"></i>
            </a>
            <a onclick="Superbox.closeGalleryEditInput(this);" href="javascript:void(0);" class="btn btn-default btn-sm" style="height: 24px;line-height: 8px;margin-top: -4px;">
                <i class="fa fa-times"></i>
            </a>
        </div>
    </td>
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