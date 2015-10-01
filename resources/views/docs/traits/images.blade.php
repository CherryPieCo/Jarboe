
<p><code>use Yaro\Jarboe\Helpers\Traits\ImageTrait;</code></p>
<p>
    Трейт для удобного вытягивания изображений.<br>
    
    Доступные методы:    
</p>

<pre>
<code class="php">
// методы трейта
::getImage($ident, $field = 'image');
::getImages($field = 'images');
::getFirstImage($ident, $field = 'images');
::getImagesCount($field = 'images');

// дальше получаем объект изображения
::src($ident = 'original', $default = null)
::info($ident, $container = null, $default = null) // $container по дефолту локаль
</code>
</pre>            

