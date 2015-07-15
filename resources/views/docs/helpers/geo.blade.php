<p class="alert alert-error">Не использовать пока.</p>
<p class="alert alert-warning">Разбирает ip только стран постсоветского пространства.</p>

<p>
    Получения гео-информации по ip. Для использования необходима таблица по гео-координатам, которую можно создать при <code>php artisan tb::prepare</code>.<br><br>
    Пример:
</p>

<pre>
<code class="php">
// берется текущий ip
var_dump(Jarboe::geo());
// bool(false)

// при ошибке, либо отсутствии координат по ip
var_dump(Jarboe::geo('sovsem_ne_ip'));
// bool(false)

var_dump(Jarboe::geo('217.27.152.26'));
// array(1) { ["217.27.152.26"]=> array(3) { ["Town"]=> string(8) "Киев" ["Lon"]=> string(9) "30.523333" ["Lat"]=> string(9) "50.450001" } }
</code>
</pre>            

