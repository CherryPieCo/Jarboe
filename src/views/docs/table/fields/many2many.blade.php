<p>
    Отображение связи многое-ко-многим.<br>
    Пример:
</p>

<p class="alert alert-danger">Для <code>many2many</code> вместо идентификатора поля пишется любое значение, начинающееся с <code>many2many</code>, чтобы импользовать несколько <code>many2many</code> в одной форме.</p>

<pre>
<code class="php">
// текущая таблица filials
'many2many' => array(
    'caption'   => 'Предоставляемые услуги',
    'type'      => 'many_to_many',
    'show_type' => 'select2',
    'select2_search' => array(
        'placeholder'    => 'Поиск товаров',
        'minimum_length' => 3,
        'quiet_millis'   => 500,
        'per_page'       => 20,
    ),
    'hide_list' => true,
    'mtm_table'                      => 'filials2services',
    'mtm_key_field'                  => 'id_filial',  // filials2catalog.id_filial
    'mtm_external_foreign_key_field' => 'id',         // services.id
    'mtm_external_key_field'         => 'id_service', // filials2services.id_service
    'mtm_external_value_field'       => 'name',       // services.name
    'mtm_external_table'             => 'services',
    'divide_columns' => 3,
    'with_link' => '/admin/services',
    'additional_where' => array(
        'services.is_active' => array(
            'sign'  => '=',
            'value' => '1'
        )
    ),
    'extra_fields' => array(
        'price' => array(  // filials2services.price
            'caption' => 'Вариант',
            'type'    => 'text',
        )
    ),
),
</code>
</pre>

<dl class="dl-horizontal">
  <dt>show_type</dt>
  <dd>Тип отображения поля (<code>checkbox|select2|extra</code>). <span class="label bg-color-blueLight pull-right">checkbox</span></dd>
  <dt>divide_columns</dt>
  <dd>Количество колонок для внешних ключей (применимо для <code>show_type = checkbox</code>). <span class="label bg-color-blueLight pull-right">2</span></dd>
  <dt>additional_where</dt>
  <dd>Дополнительные <code>WHERE</code> запросы для выборки. <span class="label bg-color-blueLight pull-right">без доп.условий</span></dd>
  <dt>mtm_table</dt>
  <dd>Таблица связей. <span class="label bg-color-red pull-right">обязательно</span></dd>
  <dt>mtm_key_field</dt>
  <dd>Название ключа таблицы связей, ссылающийся на текущее поле. <span class="label bg-color-red pull-right">обязательно</span></dd>
  <dt>mtm_external_foreign_key_field</dt>
  <dd>Внешний ключ из таблицы <code>mtm_external_table</code> на который ссылается <code>mtm_external_key_field</code>. <span class="label bg-color-red pull-right">обязательно</span></dd>
  <dt>mtm_external_key_field</dt>
  <dd>Название ключа таблицы связей, ссылающийся на поле из второй таблицы связей <code>mtm_external_table</code>. <span class="label bg-color-red pull-right">обязательно</span></dd>
  <dt>mtm_external_value_field</dt>
  <dd>Значение, которое подтянется на фронтенд из таблицы <code>mtm_external_table</code> по полю <code>mtm_external_foreign_key_field</code>. <span class="label bg-color-red pull-right">обязательно</span></dd>
  <dt>mtm_external_table</dt>
  <dd>Название таблицы, на которую ссылается внешний ключ таблицы связей, который не является текущей таблицей.<span class="label bg-color-red pull-right">обязательно</span></dd>
  <dt>extra_fields</dt>
  <dd>Используется только при <code>show_type => extra</code>. В ключе название поля, которое находится в таблице связей. В значении его два параметра (пока <code>type</code> только <code>text</code>). <span class="label bg-color-red pull-right">обязательно при extra</span></dd>
  <dt>with_link</dt>
  <dd>Используется только при <code>show_type => checkbox</code>. Указывается ури на связанную таблицу. Название чекбокса станет ссылкой на свою запись. <span class="label bg-color-blueLight pull-right">без ссылки</span></dd>
  <dt>select2_search</dt>
  <dd>Используется только при <code>show_type => select2</code>. Если нужен поиск, вместо выборки всех значений. <span class="label bg-color-blueLight pull-right">все значения</span></dd>
  <dt>select2_search[]placeholder</dt>
  <dd>Плейсхолдер на поле поиска. <span class="label bg-color-blueLight pull-right">Поиск</span></dd>
  <dt>select2_search[]minimum_length</dt>
  <dd>Со скольки введенных символов начинать поиск. <span class="label bg-color-blueLight pull-right">3</span></dd>
  <dt>select2_search[]quiet_millis</dt>
  <dd>Сколько миллисекунд прождать перед отправкой запроса после того как пользователь перестал печатать. <span class="label bg-color-blueLight pull-right">350</span></dd>
  <dt>select2_search[]per_page</dt>
  <dd>Результатов поиска на страницу. <span class="label bg-color-blueLight pull-right">20</span></dd>


</dl>

<p>Слегка мутно. Строения таблиц из примера:</p>
<code>
<pre>
filials          - |id|...|
services         - |id|name|...|
filials2services - |id|id_filial|id_service|
</pre>
</code>