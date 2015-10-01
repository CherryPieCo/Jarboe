
@if ($is_multiple)


<div class="progress progress-micro" style="margin-bottom: 0;">
    <div class="img-progress progress-bar progress-bar-primary bg-color-redLight" role="progressbar" style="width: 0%;"></div>
</div>

<div class="input input-file">
    <span class="button">
        <input type="file" onchange="TableBuilder.uploadMultipleImages(this, '{{$name}}'); this.value = null;">
        Выбрать
    </span>
    <input type="text" 
           placeholder="Выберите изображение для загрузки" 
           readonly="readonly">
           
</div>
</label>


<div class="tb-uploaded-image-container"> 
    @if ($source)
        <ul>
        @foreach ($source as $key => $data)
            <li>
                @include('admin::tb.input.image_upload_image')
            </li>
        @endforeach
        </ul>
    @else
        <ul></ul>
    @endif
</div>
<label>

@else


<div class="progress progress-micro" style="margin-bottom: 0;">
    <div class="img-progress progress-bar progress-bar-primary bg-color-redLight" role="progressbar" style="width: 0%;"></div>
</div>

<div class="input input-file">
    <span class="button">
        <input type="file" onchange="TableBuilder.uploadImage(this, '{{$name}}'); this.value = null;">
        Выбрать
    </span>
    <input type="text" 
           placeholder="Выберите изображение для загрузки" 
           readonly="readonly">
</div>
</label>



<div class="tb-uploaded-image-container">
    @if (isset($source['sizes']['original']))
        @include('admin::tb.input.image_upload_image', [
            'data' => $source, 
            'name' => $name, 
            'attributes' => $attributes
        ])
    @endif
</div>

<label>
    
    
@endif
