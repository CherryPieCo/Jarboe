
@if ($is_multiple)


<div class="progress progress-micro" style="margin-bottom: 0;">
    <div class="img-progress progress-bar progress-bar-primary bg-color-redLight" role="progressbar" style="width: 0%;"></div>
</div>

<div class="input input-file">
    <span class="button">
        <input type="file" onchange="TableBuilder.uploadMultipleImages(this, '{{$name}}');">
        Выбрать
    </span>
    <input type="text" 
           id="{{ $name }}" 
           name="{{ $name }}"
           {{--value="{{ $value }}"--}}
           placeholder="Выберите изображение для загрузки" 
           readonly="readonly">
</div>
</label>


<div class="tb-uploaded-image-container">
    @if ($source)
        <ul>
        @foreach ($source as $key => $image)
            <li>
                <img class="images-attr-editable" 
                     data-tbnum="{{$key}}"
                     data-tbalt="{{$image['alt']}}" 
                     data-tbtitle="{{$image['title']}}"
                     data-tbident="{{$name}}" 
                     height="80px" 
                     src="{{ asset($image['sizes']['original']) }}" />
                     
                <div class="tb-btn-delete-wrap">
                    <button class="btn btn-default btn-sm tb-btn-image-delete" 
                            type="button" 
                            onclick="TableBuilder.deleteImage('{{ $key }}', '{{$name}}', this);">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            </li>
        @endforeach
        </ul>
        <script>
            TableBuilder.storage['{{$name}}'] = jQuery.parseJSON('{{$value}}');
        </script>
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
        <input type="file" onchange="TableBuilder.uploadImage(this, '{{$name}}');">
        Выбрать
    </span>
    <input type="text" 
           id="{{ $name }}" 
           name="{{ $name }}"
           {{--value="{{ $value }}"--}}
           placeholder="Выберите изображение для загрузки" 
           readonly="readonly">
</div>
</label>



<div class="tb-uploaded-image-container">
    @if (isset($source['sizes']['original']))
    <div style="position: relative; display: inline-block;">
        <img class="image-attr-editable" 
             data-tbalt="{{$source['alt']}}" 
             data-tbtitle="{{$source['title']}}"
             data-tbident="{{$name}}" 
             height="80px" 
             src="{{ asset($source['sizes']['original']) }}" />
        <div class="tb-btn-delete-wrap">
            <button class="btn btn-default btn-sm tb-btn-image-delete" 
                    type="button" 
                    onclick="TableBuilder.deleteSingleImage('{{$name}}', this);">
                <i class="fa fa-times"></i>
            </button>
        </div>
    </div>
    @endif
</div>

<label>
    @if ($source)
    <script>
    //jQuery(document).ready(function() {
        TableBuilder.storage['{{$name}}'] = jQuery.parseJSON('{{$value}}');
    //});
    </script>
    @endif
    
    
@endif
