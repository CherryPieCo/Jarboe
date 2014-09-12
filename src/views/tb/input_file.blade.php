<div class="input input-file">
    <span class="button">
        <input type="file" onchange="TableBuilder.uploadFile(this, '{{$name}}');">
        Выбрать
    </span>
    <input type="text" 
           id="{{ $name }}" 
           name="{{ $name }}"
           value="{{ $value }}"
           placeholder="@if($value) {{$value}} @else Выберите файл для загрузки @endif" 
           readonly="readonly">
</div>

<div class="tb-uploaded-file-container-{{$name}}">
    @if ($value)
    <a href="{{url($value)}}" target="_blank">Скачать</a>
    @endif
</div>
