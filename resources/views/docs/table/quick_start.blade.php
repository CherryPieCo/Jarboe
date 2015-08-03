<div class="table-responsive">
            <p>Предположим, что нам нужно построить простейшую таблицу — cписок товаров.<br>
            Для начала создадим пункт меню для админ-панели. Зайдем в конфиг и допишем следующее:</p>
<pre>
<code class="php">
array(
    'title' => 'Товары', 
    'icon'  => 'th-list',  
    'link'  => '/products',       
    'check' => function() {
        return true;
    }
),
</code>
</pre>

            <p>После этого создадим два метода. Один для принимания заппросов по GET методу, второй — методом POST.<br>
            Допишем в TableAdminController.php (создадим и допишем, если его нету, ага):</p>
            <p class="alert alert-warning">Желательно хранить все такие методы в одном конроллере, чтобы не разбрасывать однообразную логику по всему приложению.</p>
<pre>
<code class="php">
public function showProducts()
{
    $options = array(
        // обязательное поле: uri по которому идет отображение страницы
        'url'      => '/admin/products', 
        // обязательное поле: название описания, по которому строится таблица
        // в этом варианте подтянется описание по пути app/tb-definitions/products.php
        'def_name' => 'products',        
    );
    list($table, $form) = Jarboe::table($options);

    $view = View::make('admin::table', compact('table', 'form'));

    return $view;
} // end showProducts

public function handleProducts()
{
    $options = array(
        'url'      => '/admin/products',
        'def_name' => 'products',
    );
    
    return Jarboe::table($options);
} // end handleProducts  
</code>
</pre>                
  
            <p>Пропишем роуты для наших двух методов:</p>      
<pre>
<code class="php">
Route::group(array('prefix' => 'admin', 'before' => array('auth_admin', 'check_permissions')), function() {
    Route::get('/products', 'TableAdminController@showProducts');
    Route::post('/handle/products', 'TableAdminController@handleProducts');
});
</code>
</pre>  
        
            <p>И, наконец-то, создадим наше описание таблицы. Они хранятся в директории <code>app/tb-definitions</code>.<br>
               Создаем в нем <code>products.php</code> со следующим содержанием:</p>   
<pre>
<code class="php">
return array(
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
    'options' => array(
        'caption' => 'Товары',
        'ident' => 'products-container',
        'form_ident' => 'products-form',
        'table_ident' => 'products-table',
        'action_url' => '/admin/handle/products',
        'not_found' => 'NOT FOUND',
    ),
    'fields' => array(
        'id' => array(
            'caption' => '#',
            'type' => 'readonly',
            'class' => 'col-id',
            'width' => '1%',
            'hide' => true,
            'filter' => 'text',
            'is_sorting' => true
        ),
        'name' => array(
            'caption' => 'Название',
            'type' => 'text',
            'filter' => 'text',
            'is_sorting' => true
        ),
        'price' => array(
            'caption' => 'Цена',
            'type' => 'text',
            'filter' => 'text',
            'is_sorting' => true
        ),
        'is_active' => array(
            'caption' => 'Товар активен',
            'type' => 'checkbox',
            'filter' => 'select',
            'options' => array(
                1 => 'Активные',
                0 => 'He aктивные',
            ),
        ),
    ),
    'filters' => array(
    ),
    'actions' => array(
        'search' => array(
            'caption' => 'Поиск',
        ),
        'insert' => array(
            'caption' => 'Добавить',
            'check' => function() {
                return true;
            }
        ),
        'update' => array(
            'caption' => 'Update',
            'check' => function() {
                return true;
            }
        ),
        'delete' => array(
            'caption' => 'Remove',
            'check' => function() {
                return true;
            }
        ),
    ),
    
);
</code>
</pre>  
        <p class="alert alert-info">Описание построения можно почитать в соседнем табе.</p>

        <p>Теперь перейдем по ссылке <code>/admin/products</code> и насладимся таблицей.<br>
           Мои поздравления! Вы восхитительны.</p>

</div>