
<p>Основные пункты для описания таблицы:</p>
<br>

<b>db</b> - описание настроек для формирования запросов к бд.
<pre>
<code class="php">
'db' => array(
    'table' => 'products',
    'order' => array(
        'id' => 'DESC',
    ),
    'pagination' => array(
        'per_page' => 20,
        'uri' => '/admin/products',
    ),
),
</code>
</pre> 

<dl class="dl-horizontal">
  <dt>table</dt>
  <dd>Таблица из которой берутся/заносятся данные. <span class="label bg-color-red pull-right">обязательно</span></dd>
  <dt>order</dt>
  <dd>Первичная сортировка отображаемых данных. <span class="label bg-color-blueLight pull-right">без сортировки</span></dd>
  <dt>pagination.per_page</dt>
  <dd>Количество записей на страницу. <span class="label bg-color-red pull-right">обязательно</span></dd>
  <dt>pagination.uri</dt>
  <dd>Ссылка, которая отвечает за отображение таблицы (служит для построения правильной пагинации). <span class="label bg-color-red pull-right">обязательно</span></dd>
</dl>
<br>

<p>Также пагинацию можно указать в нескольких значениях, чтобы отобразить выбор на фронтенде.<br>
    В ключи массива записывается количество строк для пагинации, в значения - вывод их на фронтенде.
</p>
<pre>
<code class="php">
'pagination' => array(
    // ...
    'per_page' => array(
        1 => 'по одному', 
        20 => '20', 
        99999999 => 'Я ХОЧУ ПОВЕСИТЬ БД'
    ),
),
</code>
</pre> 
<hr>
<br>

<b>options</b> - описание настроек для формирования начального отображения форм и таблицы.
<pre>
<code class="php">
'options' => array(
    'caption'     => 'Товары',
    'ident'       => 'products-container',
    'form_ident'  => 'products-form',
    'table_ident' => 'products-table',
    'action_url'  => '/admin/handle/products',
    'not_found'   => 'NOT FOUND',
    'handler'     => 'ProductsTableHandler',
    'form_width'  => '920px',
    //'is_form_fullscreen' => true,
),
</code>
</pre> 
<dl class="dl-horizontal">
  <dt>caption</dt>
  <dd>Заголовок таблицы. <span class="label bg-color-red pull-right">обязательно</span></dd>
  <dt>ident</dt>
  <dd>Идентификатор контейнера формы и таблицы (можно любой вписать). <span class="label bg-color-red pull-right">обязательно</span></dd>
  <dt>form_ident</dt>
  <dd>Идентификатор формы (можно любой вписать). <span class="label bg-color-red pull-right">обязательно</span></dd>
  <dt>table_ident</dt>
  <dd>Идентификатор таблицы (можно любой вписать). <span class="label bg-color-red pull-right">обязательно</span></dd>
  <dt>action_url</dt>
  <dd>Ссылка, которая отвечает за обработку таблицы (для запросов методом <code>POST</code>). <span class="label bg-color-red pull-right">обязательно</span></dd>
  <dt>not_found</dt>
  <dd>Текст, который показывается, если таблица пустая. <span class="label bg-color-blueLight pull-right">No data found</span></dd>
  <dt>handler</dt>
  <dd>Имя класса хендлера для текущего описания таблицы. <span class="label bg-color-blueLight pull-right">коллбеки хендлера не влияют</span></dd>
  <dt>form_width</dt>
  <dd>Ширина для формы редактирования и создания. <span class="label bg-color-blueLight pull-right">какая-то дефолтная</span></dd>
  <dt>is_form_fullscreen</dt>
  <dd>Флаг для развертывания формы во весь экран. <span class="label bg-color-blueLight pull-right">false</span></dd>
</dl>

<hr>
<br>


<b>fields</b> - перечень полей для таблицы и формы. Ключ содержит названия поля в бд, а в значении описываются его настройки для отображения.
<pre>
<code class="php">
'fields' => array(
    'id' => array(
        'caption' => '#',
        // ...
    ),
    // ...
),
</code>
</pre> 

<hr>
<br>


<b>filters</b> - перечень условий для формирования каждой выборки данных из таблицы. В ключ записывается название поля таблицы, а в значение его способ выборки.

<p class="alert alert-danger">Важно! Значения фильтра записываются автоматически при создании нового поля.</p>

<pre>
<code class="php">
'filters' => array(
    'type' => array(
        'sign'  => '=',
        'value' => 'main'
    ),
    'status' => array(
        'sign'  => '=',
        'value' => 'active'
    )
),
</code>
</pre> 
<dl class="dl-horizontal">
  <dt>filters[]sign</dt>
  <dd>Признак сравнения. <span class="label bg-color-red pull-right">обязательно</span></dd>
  <dt>filters[]value</dt>
  <dd>Значение поля. <span class="label bg-color-red pull-right">обязательно</span></dd>
</dl>

<hr>
<br>

<b>actions</b> - перечень действий для таблицы.
<pre>
<code class="php">
'actions' => array(
    'search' => array(
        'caption' => 'Поиск',
    ),
    'insert' => array(
        'caption' => 'Добавить',
        'mode' => 'new',
        'check' => function() {
            return true;
        }
    ),
    'update' => array(),
    'delete' => array(
        'check' => function() {
            return false;
        }
    ),
),
</code>
</pre> 
<dl class="dl-horizontal">
  <dt>actions[]caption</dt>
  <dd>Заголовок для кнопки действия. <span class="label bg-color-blueLight pull-right">дефолтный</span></dd>
  <dt>actions[]mode</dt>
  <dd>Тип открытия формы (<code>new</code> - в всей странице). <span class="label bg-color-blueLight pull-right">в модалке</span></dd>
  <dt>filters[]check</dt>
  <dd>Лямбда для проверки прав на исполнение и показ действия. <span class="label bg-color-blueLight pull-right">true</span></dd>
</dl>

<hr>
<br>
<p>Вспомогательные пункты для описания таблицы:</p>
<br>

<b>export</b> - описание правил для экспорта данных по таблице.
<pre>
<code class="php">
'export' => array(
    'caption'  => 'Экспорт',
    'filename' => 'exp',
    'width'    => '300',
    'date_range_field' => 'datetime',
    'buttons' => array(
        'xls' => array(
            'caption' => 'в XLS',
        ),
        'csv' => array(
            'caption' => 'в CSV',
            'delimiter' => ';'
        ),
    ),
    'check' => function() {
        return true;
    }
),
</code>
</pre> 
<dl class="dl-horizontal">
  <dt>caption</dt>
  <dd>Заголовок для кнопки экспорта. <span class="label bg-color-blueLight pull-right">Export</span></dd>
  <dt>filename</dt>
  <dd>Префикс к экспортируемому файлу. <span class="label bg-color-blueLight pull-right">export</span></dd>
  <dt>width</dt>
  <dd>Ширина дропдауна для экспорта. <span class="label bg-color-blueLight pull-right">260</span></dd>
  <dt>date_range_field</dt>
  <dd>Название поля по которому будет происходить выборка по дате. <span class="label bg-color-blueLight pull-right">без выборки</span></dd>
  <dt>buttons</dt>
  <dd>Массив для возможных вариантов экспорта. <span class="label bg-color-red pull-right">Можно отавить пустым, но толку-то?</span></dd>
  <dt>buttons[]</dt>
  <dd>Тип экспорта (<code>xls|csv</code>). <span class="label bg-color-red pull-right">обязательно</span></dd>
  <dt>buttons[]caption</dt>
  <dd>Заголовок кнопки экспорта в формате. <span class="label bg-color-red pull-right">обязательно</span></dd>
  <dt>buttons[]delimiter</dt>
  <dd>Разделитель колонок (только для <code>csv</code>). <span class="label bg-color-blueLight pull-right">запятая (,)</span></dd>
  <dt>check</dt>
  <dd>Лямбда для проверки прав на экспорт. <span class="label bg-color-blueLight pull-right">запятая (,)</span></dd>
</dl>

<hr>

<b>import</b> - описание правил для импорта (обноления) данных по таблице.
<pre>
<code class="php">
'import' => array(
    'caption'  => 'Импорт',
    'filename' => 'imp_tem',
    'width'    => '300',
    'pk' => 'id',
    'fields' => array(
        'id'    => 'Идентификатор',
        'name'  => 'Название',
        'price' => 'Цена'
    ),
    'files' => array(
        'csv' => array(
            'caption'   => 'файл в CSV',
            'delimiter' => ';'
        ),
    ),
    'check' => function() {
        return true;
    }
),
</code>
</pre> 
<dl class="dl-horizontal">
  <dt>caption</dt>
  <dd>Заголовок для кнопки импорта. <span class="label bg-color-blueLight pull-right">Import</span></dd>
  <dt>filename</dt>
  <dd>Префикс к экспортируемому примеру импортируемого файла. <span class="label bg-color-blueLight pull-right">import_template</span></dd>
  <dt>width</dt>
  <dd>Ширина дропдауна для импорта. <span class="label bg-color-blueLight pull-right">260</span></dd>
  <dt>pk</dt>
  <dd>Ключ по которому будет производится обновление. <span class="label bg-color-blueLight pull-right">елси пустое, то возьмется первый ключ из fields</span></dd>
  <dt>fields</dt>
  <dd>Поля для импорта (ключ - название поля, значение - его заголовок). <span class="label bg-color-red pull-right">обязательно</span></dd>
  <dt>files</dt>
  <dd>Перечень типов импорта (пока доступен только <code>csv</code>). <span class="label bg-color-red pull-right">Можно отавить пустым, но толку-то?</span></dd>
  <dt>files[]caption</dt>
  <dd>Заголовок кнопки импорта в формате. <span class="label bg-color-red pull-right">обязательно</span></dd>
  <dt>files[]delimiter</dt>
  <dd>Разделитель колонок (только для <code>csv</code>). <span class="label bg-color-blueLight pull-right">запятая (,)</span></dd>
  <dt>check</dt>
  <dd>Лямбда для проверки прав на импорт. <span class="label bg-color-blueLight pull-right">запятая (,)</span></dd>
</dl>
<hr>


<b>multi_actions</b> - групповой выбор полей для действий. Представляет из себя массив ключей (идентификаторов, которые сам придумаешь) и их значений-описаний.
<pre>
<code class="php">
'multi_actions' => array(
    'oh' => array(
        'caption' => 'Remove',
        'check' => function() {
            return true;
        },
        'handle' => function($ids) {
            $errors = array_map(
                function($id) {
                     return 'Поле не редактируемо: #'. $id; 
                }, 
                $ids
            );
            
            $data = array(
                // true|false. в случае успеха/ошибки
                'status' => false,
                // массив(!) ошибок для отображения на фронтенде
                'errors' => $errors
            );
            return $data;
        },
    ),
    'hai' => array(
        'caption' => 'Щито',
        'class'   => 'bg-color-blueLight txt-color-white',
        'is_hide_rows' => true,
        'check' => function() {
            return true;
        },
        'handle' => function($ids) {
            $data = array(
                'status'  => true,
                // строка(!) для оповещения об успешности действия
                'message' => 'Запрос успешно выполнен'
            );
            return $data;
        },
    )
),
</code>
</pre> 

<dl class="dl-horizontal">
  <dt>multi_actions[]caption</dt>
  <dd>Заголовок для кнопки действия. <span class="label bg-color-red pull-right">обязательно</span></dd>
  <dt>multi_actions[]class</dt>
  <dd>Дополнительные классы к кнопке действия. <span class="label bg-color-blueLight pull-right">ничего</span></dd>
  <dt>multi_actions[]is_hide_rows</dt>
  <dd>Флаг для скрытия полей, по которым шла обработка. Скрываются после ответа об успехе. <span class="label bg-color-blueLight pull-right">false</span></dd>
  <dt>multi_actions[]check</dt>
  <dd>Замыкание для проверки прав на групповое действие. <span class="label bg-color-red pull-right">обязательно</span></dd>
  <dt>multi_actions[]handle</dt>
  <dd>Замыкание для обработки по действию. <code>$ids</code> содержит <code>id</code> выбранных полей. <span class="label bg-color-red pull-right">обязательно</span></dd>
</dl>



<hr>


<b>position</b> - разбиение полей по табам.
<pre>
<code class="php">
'position' => array(
    'tabs' => array(
        'таб 1' => array('title', 'datetime'),
        'таб 2' => array('image', 'description'),
    )
),
</code>
</pre> 

<dl class="dl-horizontal">
  <dt>tabs</dt>
  <dd>Массив опций таба. <span class="label bg-color-red pull-right">обязательно</span>
     <br> В ключе название таба, в значении - перечень идентификаторов полей, которые в нем должны отображаться.</dd>
</dl>



<hr>


<b>callbacks</b> - коллбеки для дефинишна. Все то же самое, что и в хендлере.
<pre>
<code class="php">
'callbacks' => array(
    'onUpdateRowResponse' => function(array &$response) {
        $def = $this->controller->getDefinition();
        // ...
    },
    'onDeleteRowResponse' => function(array &$response) {
        // ...
    },
),
</code>
</pre> 




