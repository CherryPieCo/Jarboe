
<p><code>use Yaro\Jarboe\Helpers\Traits\ImageTrait;</code></p>
<p>
    Трейт для удобного вытягивания изображений.<br>
    
    Доступные методы:    
</p>

<pre>
<code class="php">
$ident = 'original'; // идентификатор изображения

// поле единичной загрузки изображения
getImage($ident, $field = 'image');
getImageAlt($field = 'image');
getImageTitle($field = 'image');
getImageSource($ident, $field = 'image', $default = '');

// поле множественной загрузки изображений
getFirstImage($ident, $field = 'images');
getFirstImageAlt($field = 'images');
getFirstImageTitle($field = 'images');
getFirstImageSource($ident, $field = 'images', $default = '');
getImages($field = 'images');
getImagesCount($field = 'images');

</code>
</pre>            

