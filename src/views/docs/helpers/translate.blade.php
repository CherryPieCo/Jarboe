<p class="alert alert-danger">Не описаны возможности, которые в скором времени могут не функционировать в режиме обратной совместимости.</p>

<p>
    Переводы и все-все-все.<br><br>
    Переводы через Yandex (для этого нужно вписать api ключ в конфиг):
</p>

<pre>
<code class="php">
$text = TableBuilder::translate('Hello world', 'en-ru');
echo $text;
// Привет мир

$isHtml = true;
$text = '&lt;p&gt;'. $text .'&lt;/p&gt;';
echo TableBuilder::translate($text, 'en-uk', $isHtml);
// &lt;p&gt;Привіт світ&lt;/p&gt;

$isAutoDetect = 1;
echo  TableBuilder::translate('Привет мир', 'en', false, $isAutoDetect);
// Hello world
</code>
</pre>            

