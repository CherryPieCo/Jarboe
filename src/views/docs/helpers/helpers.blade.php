<p>
    Перечень доступных хелперов:
</p>
<br>

1. <code>dr()</code> - как и <code>dd()</code>, но <code>print_r</code> вместо <code>var_dump</code>.
<pre>
<code class="php">
dr($array);
</code>
</pre>            
<br>

2. <code>__()</code> - используется для переводов слов/фраз в шаблонах. Не передавайте половину верстки, разбивайте перевод на смысловые части. Если перевод не найден, то вернется сформироавнный передаваемый шаблон.
<pre>
<code class="php">
// простое использование
__('Пример');

// немного сложнее
__('а тут %sжирно%s', '&lt;b&gt;', '&lt;/b&gt;');

// немного сложнее предыдущего
__('Кругом не %2$s, а %1$s', 'хламидомонады', 'люди');
</code>
</pre>            
<br>

3. <code>cartesian()</code> - для просчета <a href="https://ru.wikipedia.org/wiki/%D0%9F%D1%80%D1%8F%D0%BC%D0%BE%D0%B5_%D0%BF%D1%80%D0%BE%D0%B8%D0%B7%D0%B2%D0%B5%D0%B4%D0%B5%D0%BD%D0%B8%D0%B5" target="_blank">декартового произведения множеств</a>.
<pre>
<code class="php">
$array = array(
    array(11, 33),
    array(22), 
);
$isElementsDuplicated = false; // false по дефолту
$result = cartesian($array, $isElementsDuplicated);

$expected = array(
    array(11, 22),
    array(33, 22),
);
var_dump($result == $expected);
// bool(true)
</code>
</pre>            
<br>


