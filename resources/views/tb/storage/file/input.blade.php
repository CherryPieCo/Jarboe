
<div style="overflow: hidden;">
    <div style="float:left; width: 90%;">
        <input type="text" readonly="readonly"
               id="{{$name}}"
               value="{{{ $value }}}" 
               name="{{ $name }}" 
               placeholder="{{{ $placeholder }}}"
               class="dblclick-edit-input form-control input-sm unselectable">
        </input>
    </div>
    
    <div style="float:right;width: 9%;">
        <a onclick="TableBuilder.openFileStorageModal(this);" style="width:100%;" class="btn btn-info btn-sm" href="javascript:void(0);">Открыть</a>
    </div>
</div>

