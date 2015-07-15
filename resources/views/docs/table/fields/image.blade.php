<p>
                Поле типа <code>image</code>.<br>
                Имеет два вида отображения и функционрования:<br><br>
                1. Опции для единичной загрузки изображения:
            </p>
<pre>
<code class="php">
'image' => array(
    // ...
    'is_upload'   => true,
    'is_remote'   => false,
    'img_height'  => '100px',
    'before_link' => 'http://site.com/img/',
    'after_link'  => '?s=350',
),
</code>
</pre>            
            
            <dl class="dl-horizontal">
              <dt>is_upload</dt>
              <dd>Флаг для указания, что изображение загружается, иначе отображется текстовым полем.  <span class="label bg-color-blueLight pull-right">false</span></dd>
              <dt>is_remote</dt>
              <dd>Признак для построения ссылки на изображение (предпочтительно не указывать, если изображения загружается).  <span class="label bg-color-blueLight pull-right">false</span></dd>
              <dt>img_height</dt>
              <dd>Высота отображаемого изображения.  <span class="label bg-color-blueLight pull-right">50px</span></dd>
              <dt>before_link</dt>
              <dd>Префикс к ссылке отображаемого изображения.  <span class="label bg-color-blueLight pull-right">пустое</span></dd>
              <dt>after_link</dt>
              <dd>Постфикс к ссылке отображаемого изображения.  <span class="label bg-color-blueLight pull-right">пустое</span></dd>
            </dl>
            
            <p>Изображение сохранится в <code>JSON</code></p>
<pre>
<code class="json">
{
  "alt": "Such wow",
  "title": "Much amaze",
  "sizes": {
    "original": "/storage/products/01/25/44/image_0.jpg"
  }
}
</code>
</pre>  
            
            <hr>
            
            <p>2. Доп.опции для множественной загрузки изображений:</p>
<pre>
<code class="php">
'images' => array(
    // ...
    'is_multiple' => true,
    'is_upload'   => true,
),
</code>
</pre>            
            
            <dl class="dl-horizontal">
              <dt>is_multiple</dt>
              <dd>Флаг для указания, что используется множественная загрузка.  <span class="label bg-color-blueLight pull-right">false</span></dd>
            </dl>    
            
             
            <p>Изображения сохранится в <code>JSON</code>, но немного иначе</p>
<pre>
<code class="json">
[
  {
    "alt": "First",
    "title": "First",
    "sizes": {
      "original": "/storage/products/01/25/44/image_0.jpg"
    }
  },
  {
    "alt": "Second",
    "title": "Second",
    "sizes": {
      "original": "/storage/products/01/25/44/image_1.jpg"
    }
  }
]
</code>
</pre>             
            
            <hr>
            
            <p>Также есть возможность сохранять дополнительные версии загружаемого изображения.<br>
               Пример!<br>
               Предположим, что мы любим актрису <abbr title="помимо этого еще и писателя, фотографа, музыканта и соц.деятеля">Сашу Грей</abbr> и пиксельные изображения. Сделаем миниатюру загружаемой фотки нашей актрисы более серой и пиксельной:
            </p>
<pre>
<code class="php">
'image' => array(
    // ...
    'variations' => array(
        'thumb' => array(
            'resize'    => array(30, 20),
            'greyscale' => array(),
            'pixelate'  => array(12)
        )
    ),
    'quality' => 90
),
</code>
</pre>              
                    <dl class="dl-horizontal">
                      <dt>variations</dt>
                      <dd>Список дополнительных вариантов загружаемого изображения.  <span class="label bg-color-blueLight pull-right">будет только original</span><br>
                          Ключем мы задаем идентификатор варианта изображения. В значении перечисляем методы с массивом передаваемых в них значений (<a target="_blank" href="http://image.intervention.io/">список всех методов</a>).
                      </dd>
                      <dt>quality</dt>
                      <dd>Качество сохраненных изображений.  <span class="label bg-color-blueLight pull-right">100</span><br>
                      </dd>
                    </dl>    


                        <p>В итоге мы получим:</p>
<pre>
<code class="json">
{
  "alt": "Much grey",
  "title": "So pixel",
  "sizes": {
    "original": "/storage/products/01/25/44/image_0.jpg",
    "thumb": "/storage/products/01/25/44/image_0_thumb.jpg"
  }
}
</code>
</pre>   
                    <p>Аналогично и для множественной загрузки.</p>
                    <hr>
            
            
            <p class="alert alert-info">Описание удобного доставания изображений смотреть во вкладке трейтов.</p>
            