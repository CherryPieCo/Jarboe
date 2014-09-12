
@if ($is_multiple)

<div class="input input-file">
    <span class="button">
        <input type="file" onchange="TableBuilder.uploadMultipleImages(this, '{{$delimiter}}');">
        Выбрать
    </span>
    <input type="text" 
           id="{{ $name }}" 
           name="{{ $name }}"
           value="{{ $value }}"
           placeholder="@if($value) {{$value}} @else Выберите изображение для загрузки @endif" 
           readonly="readonly">
</div>

<div class="tb-uploaded-image-container">
    <?php
    $images = array_filter(explode($delimiter, $value));
    ?>
    @if ($images)
        <ul>
        @foreach ($images as $image)
            <li>
                <img src="{{ url($image) }}" />
                <div class="tb-btn-delete-wrap">
                    <button class="btn btn-default btn-sm tb-btn-image-delete" 
                            type="button" 
                            onclick="TableBuilder.deleteImage('{{ urlencode($image) }}', '{{$delimiter}}', this);">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            </li>
        @endforeach
        </ul>
    @else
        <ul></ul>
    @endif
</div>

@else

<div class="input input-file">
    <span class="button">
        <input type="file" onchange="TableBuilder.uploadImage(this);">
        Выбрать
    </span>
    <input type="text" 
           id="{{ $name }}" 
           name="{{ $name }}"
           value="{{ $value }}"
           placeholder="@if($value) {{$value}} @else Выберите изображение для загрузки @endif" 
           readonly="readonly">
</div>

<div class="tb-uploaded-image-container">
    @if ($value)
    <img height="80px" src="{{ url($value) }}" />
    @endif
</div>

@endif
