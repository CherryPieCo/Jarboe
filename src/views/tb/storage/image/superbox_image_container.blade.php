
@if (!$sizes)

<img src="{{ asset($image->getSource()) }}" class="superbox-current-img">
<a download="{{ $image->title }}" target="_blank" href="{{ asset($image->getSource()) }}" class="j-btn-download btn btn-default btn-sm" style="position: absolute; top: 30px; left: 30px;">скачать</a>

@else
<ul id="j-images-sizes-tabs" class="nav nav-tabs bordered" style="width: 58%;">
    <li class="active">
        <a href="#j-images-size-original" data-toggle="tab">Оригинал</a>
    </li>

    @foreach ($sizes as $ident => $info)
        <li>
            <a href="#j-images-size-{{ $ident }}" data-toggle="tab">{{ $info['caption'] }}</a>
        </li>
    @endforeach
</ul>

<div id="j-images-sizes-tabs-content" class="tab-content padding-10" style="overflow: auto; width: 60%; float: left; border: none;">
    <div class="tab-pane fade in active" id="j-images-size-original">
    <p>
        <img src="{{ asset($image->getSource()) }}" class="superbox-current-img" style="width: auto;display: block;margin: 0 auto;float: none;">
        <a download="{{ $image->title }}" target="_blank" href="{{ asset($image->getSource()) }}" class="j-btn-download btn btn-default btn-sm" style="position: absolute; top: 78px; left: 40px;">скачать</a>
    </p>
        <form class="smart-form pull-left">
        <div class="input input-file" style="width: 350px;">
            <span class="button">
                <input type="file" name="image" accept="image/*" onchange="Superbox.uploadSingleImage(this, '', {{$image->id}});">
                Выбрать
            </span>
            <input type="text" readonly="readonly" placeholder="Загрузить новое изображение">
        </div>
        </form>
    </div>
    
    @foreach ($sizes as $ident => $info)
        <div class="tab-pane fade" id="j-images-size-{{ $ident }}">
        <p>
            <img src="{{ asset($image->getSource($ident)) }}" class="superbox-current-img" style="width: auto;display: block;margin: 0 auto; float: none;">
            <a download="{{ $image->title .'('. $info['caption'] .')' }}" target="_blank" href="{{ asset($image->getSource($ident)) }}" class="j-btn-download btn btn-default btn-sm" style="position: absolute; top: 78px; left: 40px;">скачать</a>
        </p>
            <form class="smart-form pull-left">
            <div class="input input-file" style="width: 350px;">
                <span class="button">
                    <input type="file" name="image" accept="image/*" onchange="Superbox.uploadSingleImage(this, '{{ $ident }}', {{$image->id}});">
                    Выбрать
                </span>
                <input type="text" readonly="readonly" placeholder="Загрузить новое изображение">
            </div>
            </form>
        </div>
    @endforeach
</div>
@endif



<div id="imgInfoBox" class="superbox-imageinfo inline-block" style="{{ $sizes ? 'margin-top: -40px;' : '' }}"> 
    <h1># {{ $image->id }}: {{ $image->title }} ({{ $image->created_at }})</h1>
    
    <span style="display:inline;margin:0;">
        <form class="smart-form">
        <fieldset>
            @foreach ($fields as $ident => $info)
            <section>
                <label class="label">{{ $info['caption'] }}</label>
                    <label class="input">
                        <input class="input-xs" name="{{ $ident }}" value="{{ $image->get($ident) }}">
                    </label>
            </section>
            @endforeach
        </fieldset>
        
        {{ $select2 }}
        
        
        <p class="well" style="overflow: auto;padding: 20px 8px 8px;margin: 0px;">
            <a onclick="Superbox.saveImageInfo(this, {{ $image->id }});" href="javascript:void(0);" 
                                          class="btn btn-success btn-sm pull-right j-btn-save">Сохранить</a> 
            <a onclick="Superbox.selectImage(this, {{ $image->id }});" href="javascript:void(0);" 
                                          class="j-image-storage-select-image-btn btn btn-primary btn-sm pull-right j-btn-save" 
                                          style="margin-right: 6px;">Выбрать</a> 
            <a onclick="Superbox.deleteImage(this, {{ $image->id }});" href="javascript:void(0);" 
                                          class="btn btn-danger btn-sm pull-left j-btn-del">Удалить</a>
        </p>
    </span> 
</div>