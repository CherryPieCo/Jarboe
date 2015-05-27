<tr>
    <td>{{ $file->id }}</td>
    <td>{{ $file->title }}</td>
    <td><a download="{{$file->title}}" target="_blank" href="{{ asset($file->source) }}">{{ $file->getMimeType() }} <br> {{ filesize_format($file->getSize()) }}</a></td>
    <td width="1%">
        <a href="javascript:void(0);" class="btn btn-default btn-sm" 
           onclick="FileStorage.selectFile(this, {{ $file->id }});">
            Выбрать
        </a>
    </td>
    <td width="1%" style="min-width: 94px;">
        <a href="javascript:void(0);" class="btn btn-default btn-sm" 
           onclick="FileStorage.editFileInfo(this, {{ $file->id }});" style="margin-right: 5px;">
            <i class="fa fa-pencil"></i>
        </a>
        <a href="javascript:void(0);" class="btn btn-default btn-sm" 
           onclick="FileStorage.deleteFile(this, {{ $file->id }});">
            <i class="fa fa-times"></i>
        </a>
    </td>
</tr>