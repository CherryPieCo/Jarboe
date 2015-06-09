<tr class="file-storage-edit-form-tr">
<td colspan="6">
    <form class="form-horizontal" style="margin-bottom: 20px;">
                                            
        <fieldset>
            <legend>#{{$file->id}}: {{$file->title}}</legend>
            
            @foreach ($fields as $ident => $info)
            <div class="form-group">
                <label class="col-md-2 control-label">{{ $info['caption'] }}</label>
                <div class="col-md-10">
                    <input class="form-control" value="{{{ $file->get($ident) }}}" placeholder="{{ $info['placeholder'] or '' }}" name="{{ $ident }}" type="text">
                </div>
            </div>
            @endforeach
            
            <hr>
            <div class="form-group">
                <label class="col-md-2 control-label">Перезагрузить файл</label>
                <div class="col-md-10">
                    <input type="file" class="btn btn-default" onchange="FileStorage.reuploadFile(this, {{ $file->id }});">
                </div>
            </div>
        </fieldset>
        
        
        <div class="form-actions">
            <div class="row">
                <div class="col-md-12">
                    <a onclick="FileStorage.saveFileInfo(this, {{$file->id}});" class="btn btn-primary" href="javascript:void(0);">
                        <i class="fa fa-save"></i>
                        Сохранить
                    </a>
                    <a onclick="FileStorage.closeEditForm();" class="btn btn-default" href="javascript:void(0);">
                        Отмена
                    </a>
                </div>
            </div>
        </div>

    </form>
</td>
</tr>