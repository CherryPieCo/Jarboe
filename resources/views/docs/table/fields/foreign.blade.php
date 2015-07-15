<p>
    Отображение внешнего ключа.<br>
    Пример:
</p>
    
<pre>
<code class="php">
'id_city' => array(
    'caption' => 'Город',
    'type'    => 'foreign',
    'select_type' => 'select2',
    'filter'  => 'text',
    'is_null' => true,
    'null_caption' => 'Без города',
    'is_readonly'  => false,
    'alias'        => 'c',
    'foreign_table'       => 'cities',
    'foreign_key_field'   => 'id',
    'foreign_value_field' => 'name',
    'additional_where' => array(
        'cities.type' => array(
            'sign'  => '=',
            'value' => 'capital'
        )
    )
),
</code>
</pre>            
    
<dl class="dl-horizontal">
  <dt>select_type</dt>
  <dd>Тип отображения селекта. <code>simple|select2</code> <span class="label bg-color-blueLight pull-right">simple</span></dd>
  <dt>is_null</dt>
  <dd>Если внешний ключ может быть <code>NULL</code>. Делается не <code>INNER JOIN</code>, а <code>LEFT JOIN</code>. <span class="label bg-color-blueLight pull-right">false</span></dd>
  <dt>null_caption</dt>
  <dd>Отображение для поля со значением <code>NULL</code>. <span class="label bg-color-blueLight pull-right">...</span><span style="margin-right:3px;" class="label bg-color-blueLight pull-right">fa-minus</span></dd>
  <dt>is_readonly</dt>
  <dd>Редактируем ли внешний ключ. <span class="label bg-color-blueLight pull-right">false</span></dd>
  <dt>alias</dt>
  <dd>Псевдоним для внешней таблицы при построении запроса. <span class="label bg-color-red pull-right">желательно</span><br>
      Особенно важен, если таблица ссылается на саму себя.</dd>
  <dt>foreign_table</dt>
  <dd>Название внешней таблицы. <span class="label bg-color-red pull-right">обязательно</span></dd>
  <dt>foreign_key_field</dt>
  <dd>Ключ внешней таблицы, на который ссылается данное поле. <span class="label bg-color-red pull-right">обязательно</span></dd>
  <dt>foreign_value_field</dt>
  <dd>Значение из внешней таблицы, которое подтянется вместо идентификатора текущей таблицы. <span class="label bg-color-red pull-right">обязательно</span></dd>
  <dt>additional_where</dt>
  <dd>Перечень дополнительных условий для выборки внешних ключей. <span class="label bg-color-blueLight pull-right">без них</span></dd>
  

</dl>