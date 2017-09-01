<div class="well well-sm">
<h3 class="text-primary">Конфиги:</h3>
                    
<div class="bs-example">
На текущий момент мы располагаем четырьмя конфигами, которые находятся в <code>app/config/packages/yaro/jarboe</code>.
</div>          
<br>
<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-10" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-custombutton="false" data-widget-sortable="false" role="widget" style="">
    <header role="heading">
        <span class="widget-icon"> <i class="fa fa-lg fa-fw fa-cog"></i> </span>
        <h2>Описание конфигов</h2>
        <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
    </header>

    <!-- widget div-->
    <div role="content">

        <!-- widget content -->
        <div class="widget-body no-padding">

            <div class="panel-group smart-accordion-default" id="accordion-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion-2" href="#collapseOne-1" class="collapsed"> <i class="fa fa-fw fa-plus-circle txt-color-green"></i> <i class="fa fa-fw fa-minus-circle txt-color-red"></i> admin.php </a></h4>
                    </div>
                    <div id="collapseOne-1" class="panel-collapse collapse" style="height: 0px;">
                        <div class="panel-body">
                            <dl class="dl-horizontal">
                              <dt>uri</dt>
                              <dd>Сегмент URL для обозначения зоны админ-панели (меняем только если это требование проекта).</dd>
                              <dt>user_name</dt>
                              <dd>Имя аккаунта для отображения в админке.</dd>
                              <dt>user_image</dt>
                              <dd>Аватарка аккаунта для отображения в админке.</dd>
                              <dt>yandex_api_translation_key</dt>
                              <dd>API ключ от Yandex Translate (необходим для использования <code>Jarboe::translate()</code>).</dd>
                              <dt>menu</dt>
                              <dd>Содержит массив, по которому строится навигационное меню админ-панели.</dd>
                            </dl>
                            
<pre>
<code class="php">
'menu' => array(
    // Одномерный пункт
    array(
        // Заголовок пункта меню
        'title' => 'Главная', 
        // Постфикс font-awesome иконки
        // Если нужна fa-picture-o, то пишем picture-o)
        'icon'  => 'home',  
        // Ссылка на пункт меню (без префикса)
        // Пример: для http://site.com/admin/fcuk тут нужно записать только fcuk
        'link'  => '/',       
        // Проверка прав на отображение пункта меню. 
        // true|false — показывать|скрывать
        'check' => function() {
            return true;
        }
    ),
    // Многомерный пункт
    // Элементы submenu могу содержать свои submenu
    // Лямбда функция check используется только для конечных пунктов
    array(
        'title' => 'Упр. пользователями',
        'icon'  => 'user',
        'submenu' => array(
            array(
                'title'   => 'Пользователи',
                'link'    => '/tb/users',
                // Паттерн для регулярки. Заменяет сравнивание текущего пути по 'link'
                'pattern' => '/tb/users/?\d*',
                'check'   => function() {
                    return true;
                }
            ),
            array(
                'title' => 'Группы',
                'link'  => '/tb/groups',
                'check' => function() {
                    $readOnly = Sentry::findGroupByName('readonly');
                    return !Sentry::getUser()->inGroup($readOnly);
                }
            ),
        )
    ),
),
</code>
</pre>
                            
                        </div>
                    </div>
                </div>
                
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion-2" href="#collapseThree-1" class="collapsed"> <i class="fa fa-fw fa-plus-circle txt-color-green"></i> <i class="fa fa-fw fa-minus-circle txt-color-red"></i> images.php </a></h4>
                    </div>
                    <div id="collapseThree-1" class="panel-collapse collapse">
                        <div class="panel-body">
                            <dl class="dl-horizontal">
                              <dt>models</dt>
                              <dd>Модели, которые пакет будет использовать при манипуляциях с сущностями хранилища.</dd>
                              <dt>image[]fields</dt>
                              <dd>Перечень полей для вкидывания в поле <code>info</code> таблицы изображений.</dd>
                            </dl>
                            
<pre>
<code class="php">
'models' => array(
    'image'   => 'Yaro\Jarboe\Image',
    'gallery' => 'Yaro\Jarboe\Gallery',
    'tag'     => 'Yaro\Jarboe\Tag',
    'storage' => 'Yaro\Jarboe\ImageCatalog',
),

'image' => array(
    'fields' => array(
        'title' => array( // идентификатор поля
            'caption' => 'Caption', // заголовок поля
        ),
    )
),
</code>
</pre>

                        </div>
                    </div>
                </div>
                
                
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion-2" href="#collapseTwo-1" class="collapsed"> <i class="fa fa-fw fa-plus-circle txt-color-green"></i> <i class="fa fa-fw fa-minus-circle txt-color-red"></i> login.php </a></h4>
                    </div>
                    <div id="collapseTwo-1" class="panel-collapse collapse" style="height: 0px;">
                        <div class="panel-body">
                            <dl class="dl-horizontal">
                              <dt>is_active_remember_me</dt>
                              <dd>Отображение кнопки "запомнить меня".</dd>
                              <dt>background_url</dt>
                              <dd>Ссылка для фона страницы входа в админ-панель.</dd>
                              <dt>favicon_url</dt>
                              <dd>Ссылка на логотип сайта (отображение в правом верхнем углу формы входа).</dd>
                              <dt>top_block</dt>
                              <dd>HTML блока над формой входа.</dd>
                              <dt>bottom_block</dt>
                              <dd>HTML блока под формой входа.</dd>
                              <dt>on_login</dt>
                              <dd>Анонимка, которая вызывается после авторизации для входа в админ-панель.</dd>
                              <dt>on_logout</dt>
                              <dd>Анонимка, которая вызывается после выхода из админ-панели.</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion-2" href="#collapseThree-1" class="collapsed"> <i class="fa fa-fw fa-plus-circle txt-color-green"></i> <i class="fa fa-fw fa-minus-circle txt-color-red"></i> informer.php </a></h4>
                    </div>
                    <div id="collapseThree-1" class="panel-collapse collapse">
                        <div class="panel-body">
                            <dl class="dl-horizontal">
                              <dt>period</dt>
                              <dd>Частота обновления информера (задается в секундах).</dd>
                              <dt>tabs</dt>
                              <dd>Массив, по которому строится информер.</dd>
                            </dl>
                            
<pre>
<code class="php">
'tabs' => array(
    // Каждый пункт информера записывается массивом
    // Сколько массивов, столько и пунктов
    array(
        // Заголовок пункта
        'caption' => 'Новые комментарии',
        'info' => array(
             // Лямбда для получения отображаемого количества
             'count'   => function() {
                 return rand(0, 12);
             },
             // Лямбда для получения контента по пункту информера
             'content'   => function() {
                 return '&lt;p style="padding: 20px;"&gt;Шутка, нету новых комментариев&lt;/p&gt;';
             },
        ),
        // Лямбда для проверки прав на показ пункта информера. true|false
        'check' => function() {
            return true;
        }
    ),
    array(
        'caption' => 'Непросмотренные заказы',
        'info' => array(
             'count'   => function() {
                 return DB::table('orders')->where('status', 'pending')->count();
             },
             'content'   => function() {
                 $orders = Order::with('user')->where('status', 'pending')->take(6)->get();
                 
                 $html = '';
                 foreach ($orders as $order) {
                     $html .= '&lt;p&gt;'. $order->user->name .'-'. $order->getSum() .'&lt;/p&gt;';
                 }
                 
                 return $html;
             },
        ),
        'check' => function() {
            return true;
        }
    ),
),
</code>
</pre>

                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion-2" href="#collapseFour-1" class="collapsed"> <i class="fa fa-fw fa-plus-circle txt-color-green"></i> <i class="fa fa-fw fa-minus-circle txt-color-red"></i> users.php </a></h4>
                    </div>
                    <div id="collapseFour-1" class="panel-collapse collapse">
                        <div class="panel-body">
                            <p class="alert alert-danger">Важно! Конфиг в ближайшем времени будет дополняться.</p>
                            <p class="alert alert-warning">Как использовать это разделение прав с группами и их наследованием? <a href="https://cartalyst.com/manual/sentry#permissions" target="_blank">Вот так</a>.</p>
                            <dl class="dl-horizontal">
                              <dt>permissions</dt>
                              <dd>Список отображаемых прав для их установления к пользователю или группе.</dd>
                              <dt>check</dt>
                              <dd>Массив с проверкой прав на действия с пользователями (желательно сразу поменять их на необходимые).</dd>
                            </dl>
                            
<pre>
<code class="php">
'permissions' => array(
    // Идентификатор группы прав
    'user' => array(
        // Заголовок группы
        'caption' => 'Пользователи',
        // И сами права с их заголовками
        'rights'  => array(
            'view'   => 'Просмотр',
            'create' => 'Создание',
            'update' => 'Редактирование',
            'delete' => 'Удаление',
        ),
    ),
    // Для примера. В проекте не использовать!
    'grindgod' => array(
        'caption' => 'Искры ананаса',
        'rights'  => array(
            'open'     => 'Открытие',
            'jump'     => 'Прыгать',
            'rumbling' => 'Урчание',
        ),
    ),
),
// Если читали предыдущие пункты, то здесь вопросов не будет.
'check' => array(
    'users' => array(
        'create' => function() {
            return true;
        },
        'update' => function() {
            return true;
        },
        'delete' => function() {
            return true;
        },
    ),
    'groups' => array(
        'create' => function() {
            return true;
        },
        'update' => function() {
            return true;
        },
        'delete' => function() {
            return true;
        },
    ),
),
</code>
</pre>
                            
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- end widget content -->

    </div>
    <!-- end widget div -->

</div>
</div>
