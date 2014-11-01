<p>
    Отображение внешнего ключа.<br>
    Пример:
</p>
    
<pre>
<code class="php">
'id_city' => array(
    'caption' => 'Город',
    'type'    => 'foreign',
    'filter'  => 'text',
    'alias'   => 'c',
    'foreign_table'       => 'cities',
    'foreign_key_field'   => 'id',
    'foreign_value_field' => 'name',
),
</code>
</pre>            
    
<dl class="dl-horizontal">
  <dt>alias</dt>
  <dd>Псевдоним для внешней таблицы при построении запроса. <span class="label bg-color-red pull-right">обязательно</span><br>
      Особенно важен, если таблица ссылается на саму себя.</dd>
  <dt>foreign_table</dt>
  <dd>Название внешней таблицы. <span class="label bg-color-red pull-right">обязательно</span></dd>
  <dt>foreign_key_field</dt>
  <dd>Ключ внешней таблицы, на который ссылается данное поле. <span class="label bg-color-red pull-right">обязательно</span></dd>
  <dt>foreign_value_field</dt>
  <dd>Значение из внешней таблицы, которое подтянется вместо идентификатора текущей таблицы. <span class="label bg-color-red pull-right">обязательно</span></dd>
</dl>