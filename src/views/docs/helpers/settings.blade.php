
<p>
    Класс для вытягивания настроек приложения.<br>
    Доступные методы:    
</p>

<pre>
<code class="php">
var_dump(Settings::get('site_caption'));
// string(7) "My Site"

Settings::get('non_existed_ident');
// @throws RuntimeException

var_dump(Settings::has('non_existed_ident'));
// bool(false)

echo Settings::get('pagination_variants');
// string(10) "5|20 | 40 "

$delimiter = '|'; // default is ','
var_dump(Settings::getChunks('pagination_variants', $delimiter));
// array(3) { [0]=> int(5) [1]=> int(20) [2]=> int(40) }

var_dump(Settings::getFirstChunk('pagination_variants', $delimiter));
// int(5)

// Settings::hasChunk($needle, $ident[, $delimiter = ',', $isCaseSensitive = true])
var_dump(Settings::hasChunk('hai', 'say_hai_setting', '|', false));
</code>
</pre>            

