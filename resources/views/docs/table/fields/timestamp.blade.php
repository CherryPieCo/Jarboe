<p class="alert alert-danger">На данный момент поддерживается <code>TIMESTAMP</code> исключительно от <code><a href="https://mariadb.org/" target="_blank">MariaDB</a></code>.</p>
<p>
    Поле типа <code>timestamp</code>.<br>
    Внешне функционирует как и <code>datetime</code>.<br>
    Дополнительные опции:
</p>

<pre>
<code class="php">
'show_date' => array(
    // ...
    'months'   => 2,
    'is_range' => true
),
</code>
</pre>            

<dl class="dl-horizontal">
  <dt>months</dt>
  <dd>Количетво отображаемых месяцев в форме редактирования и создания.  <span class="label bg-color-blueLight pull-right">1</span></dd>
  <dt>is_range</dt>
  <dd>Признак фильтрации по промежутку дат.  <span class="label bg-color-blueLight pull-right">false</span></dd>
</dl>