<tr>
    <td>{{ $file->id }}</td>
    <td>{{ $file->title }}</td>
    <td><a target="_blank" href="{{ asset($file->source) }}">{{ asset($file->source) }}</a></td>
    <td width="1%">
        <a href="javascript:void(0);" class="btn btn-default btn-sm" 
           onclick="FileStorage.selectFile(this, {{ $file->id }});">
            Выбрать
        </a>
    </td>
    <td width="1%">
        <a href="javascript:void(0);" class="btn btn-default btn-sm" 
           onclick="FileStorage.deleteFile(this, {{ $file->id }});">
            <i class="fa fa-times"></i>
        </a>
    </td>
</tr>