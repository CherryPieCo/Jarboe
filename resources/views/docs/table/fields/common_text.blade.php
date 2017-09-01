<p>
    Пример поля с типом <code>text</code>:
</p>
<pre>
<code class="php">
'title' => array(
    'caption'     => 'Title',
    'type'        => 'text',
    'filter'      => 'text',
    'class'       => 'col-id',
    'width'       => '1%',
    'hide'        => true,
    'hide_list'   => true,
    'mask'        => 'aa - a'
    'is_sorting'  => true,
    'placeholder' => 'Just a placeholder',
),
</code>
</pre>
<br>
            <dl class="dl-horizontal">
              <dt>caption</dt>
              <dd>Отображаемый заголовок для поля. <span class="label bg-color-blueLight pull-right">идентификатор самого поля</span></dd>
              <dt>type</dt>
              <dd>Его тип, по которому оно формируется и валидируется. <span class="label bg-color-red pull-right">обязательное</span></dd>
              <dt>filter</dt>
              <dd>Тип поля для фильтрации. <span class="label bg-color-blueLight pull-right">не отображается поле фильтрации</span></dd>
              <dt>class</dt>
              <dd>Добавляемый класс к колонке этого поля. <span class="label bg-color-blueLight pull-right">без доп.класса</span></dd>
              <dt>width</dt>
              <dd>Ширина колонки этого поля. <span class="label bg-color-blueLight pull-right">без ширины</span></dd>
              <dt>hide</dt>
              <dd>Флаг для скрытия отображения в форме создания и обновления. <span class="label bg-color-blueLight pull-right">отображается в форме</span></dd>
              <dt>hide_list</dt>
              <dd>Флаг для скрытия отображения поля в списке. <span class="label bg-color-blueLight pull-right">отображается в списке</span></dd>
              <dt>mask</dt>
              <dd>Маска для поля (пока что используется <a target="_blank" href="http://digitalbush.com/projects/masked-input-plugin/">этот плагин</a>). <span class="label bg-color-blueLight pull-right">без маски</span></dd>
              <dd>Лучше пока воздержаться от использования маски, т.к. в ближайшем времени она видоизменится.</dd>
              <dt>is_sorting</dt>
              <dd>Сортировка ASC/DESC по нажатию на заголовок поля. <span class="label bg-color-blueLight pull-right">без сортировки</span></dd>
              <dt>placeholder</dt>
              <dd>Плейсхолдер для поля. <span class="label bg-color-blueLight pull-right">без плейсхолдера</span></dd>
            </dl>
            
            <hr>
            
            <p>
                Также можно и желательно использовать валидацию для поля.<br>
                Как обычно, она делится на две части: фронтенд и бэкенд.
            </p>
<pre>
<code class="php">
'email' => array(
    // ...
    'validation' => array(
        'server' => array(
            'rules' => 'required|email',
            'messages' => array(
                'required' => 'Обязательно к заполнению',
                'email'    => 'Не валидный имейл',
            )  
        ),
        'client' => array(
            'rules' => array(
                'required' => true
            ),
            'messages' => array(
                'required' => 'Обязательно к заполнению'
            )   
        )
    ),
),
</code>
</pre>
            <dl class="dl-horizontal">
              <dt>server.rules</dt>
              <dd>Обычный перечень правил для валидации класса <code>Validation</code> (<a href="http://laravel.com/docs/4.2/validation#available-validation-rules" target="_blank">перечень тут</a>)</dd>
              <dt>server.messages</dt>
              <dd>Перечень кастомных сообщений по серверной валидации.</dd>
              <dt>client.rules</dt>
              <dd>В отличии от серверной части, записываются в массив. (о возможных правилах можно <a href="http://jqueryvalidation.org/documentation/" target="_blank">почитать тут</a>)</dd>
              <dt>client.messages</dt>
              <dd>Перечень кастомных сообщений по клиентской валидации.</dd>
            </dl>

            <hr>

            <p>Плюс ко всему можно использовать табы для поля (табы доступны не для всех типов полей).<br>
            Обычно табы используются для записи разных языковых версий поля.</p>

<pre>
<code class="php">
'name' => array(
    // ...
    'tabs' => array(
        array(
            'caption'     => 'ru',
            'postfix'     => '',
            'placeholder' => 'Название на русском'
        ),
        array(
            'caption'     => 'ua',
            'postfix'     => '_ua',
            'placeholder' => 'Название на украинском'
        ),
    ),
),
</code>
</pre>

            <dl class="dl-horizontal">
              <dt>tabs</dt>
              <dd>Массив табов (сколько вписать, столько и отобразится).</dd>
              <dt>tabs[]caption</dt>
              <dd>Заголовок таба.</dd>
              <dt>tabs[]postfix</dt>
              <dd>Постфикс поля (в примере запись будет идти на два поля: name и name_ua).</dd>
              <dt>tabs[]placeholder</dt>
              <dd>Плейсхолдер для поля в табе (ес-но, отобразится только для поля с типом <code>text</code>).</dd>
            </dl>

            <p class="alert alert-info">Как норм доставать эти переводы? Смотреть вкладку трейтов.</p>