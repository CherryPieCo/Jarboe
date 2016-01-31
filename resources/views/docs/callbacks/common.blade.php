
<p class="alert alert-info">Не хватает? Сообщаем.</p>

<p>Коллбеки в построении таблиц служат для расширения обработки данных таблицы под специфические нужды без прямого вмешательства в функционирующий код.</p>
<hr>

<p>Установка хендлера с коллебками за пару шагов:</p>
<ol>
    <li>Прописать в описании таблицы <code>'handler' => 'MyCustomTableHandler'</code>.</li>
    <li>Создать сам класс хендлера и унаследовать его от <code>Yaro\Jarboe\Handlers\CustomHandler</code>.</li>
    <li>Радоваться.</li>
</ol>
<hr>

<p>Методы, которыми можно вмешаться в волшебный ход событий:</p>

<ol>
<li>
    <code>handle()</code>
    <p>Вызывается перед каждым действием. И если есть возвращаемое значение, то остальной код не исполняется. Мутите все сами.</p>
<pre>
<code class="php">            
public function handle()
{
    die('what am I doing here?');
} // end handle
</code>
</pre>  
</li>

<li>
    <code>onGetValue($formField, array &$row, &$postfix)</code>
    <p>Вызывается перед каждым получением значения поля. Возвращаемое значение прекращает продолжение логического блока.</p>
    <dl class="dl-horizontal">
      <dt>$formField</dt>
      <dd>Объект поля.</dd>
      <dt>$row</dt>
      <dd>Массив значений поля на текущий момент.</dd>
      <dt>$postfix</dt>
      <dd>Постфикс поля (при использовании табов).</dd>
    </dl>
<pre>
<code class="php">            
public function onGetValue($formField, array &$row, &$postfix)
{
    return 'wtf';
} // end onGetValue
</code>
</pre>  
</li>

<li>
    <code>onGetExportValue($formField, $type, array &$row, &$postfix)</code>
    <p>Вызывается перед каждым получением значения при экспорте. Возвращаемое значение прекращает продолжение логического блока.</p>
    <dl class="dl-horizontal">
      <dt>$type</dt>
      <dd>Тип экспорта.</dd>
    </dl>
</li>

<li>
    <code>onGetEditInput($formField, array &$row)</code>
    <p>Вызывается перед каждым получением <code>html</code> для поля. Возвращаемое значение прекращает продолжение логического блока.</p>
</li>

<li>
    <code>onGetListValue($formField, array &$row)</code>
    <p>Вызывается перед каждым получением значения поля для вывода его в таблицу. Возвращаемое значение прекращает продолжение логического блока.</p>
</li>

<li>
    <code>onPrepareSearchFilters(array &$filters)</code>
    <p>Вызывается после формирования значений фильтра по таблице и перед сохранением их в сессию.</p>
    <dl class="dl-horizontal">
      <dt>$filters</dt>
      <dd>Массив фильтров пользователя.</dd>
    </dl>
<pre>
<code class="php">            
public function onPrepareSearchFilters(array &$filters)
{
    $filters = array();
} // end onPrepareSearchFilters
</code>
</pre> 
</li>

<li>
    <code>onSearchFilter(&$db, $name, $value)</code>
    <p>Вызывается на каждой итерации при формировании выборки по фильтрам. Возвращаемое значение прерывает выполнение логического блока на текущей итерации.</p>
    <dl class="dl-horizontal">
      <dt>$db</dt>
      <dd>Инстанс <code>Fluent</code>.</dd>
      <dt>$name</dt>
      <dd>Поле для выборки.</dd>
      <dt>$value</dt>
      <dd>Значение поля для выборки.</dd>
    </dl>
<pre>
<code class="php">            
public function onSearchFilter(&$db, $name, $value)
{
    if ($name == 'title') {
        $db->where($name, 'LIKE', '%котики%');
    }
} // end onSearchFilter
</code>
</pre> 
</li>

<li>
    <code>onUpdateRowResponse(array &$response)</code>
    <p>Вызывается после обновления поля.</p>
    <dl class="dl-horizontal">
      <dt>$response</dt>
      <dd>Массив из двух ключей:</dd>
      <dd><b>id</b> - значение первичного ключа обновленного поля.</dd>
      <dd><b>values</b> - массив подготовленных значений, что были задествованы при обновлении поля.</dd>
    </dl>
<pre>
<code class="php">            
public function onUpdateRowResponse(array &$response)
{
    Cache::forget('my_saved_key');
} // end onUpdateRowResponse
</code>
</pre> 
</li>

<li>
    <code>onInsertRowResponse(array &$response)</code>
    <p>Вызывается после создания поля. Все как и при <code>onUpdateRowResponse</code>.</p>
</li>

<li>
    <code>onDeleteRowResponse(array &$response)</code>
    <p>Вызывается после удаления поля.</p>
    <dl class="dl-horizontal">
      <dt>$response</dt>
      <dd>Массив из двух ключей:</dd>
      <dd><b>id</b> - значение первичного ключа удаленного поля.</dd>
      <dd><b>status</b> - значение, что возвращает <code>Fluent</code> при вызове <code>delete()</code>.</dd>
    </dl>
</li>

<li>
    <code>handleDeleteRow($id)</code>
    <p>Переопределение полностью всей логики по удалению. Возвращаемое значение прерывает логический блок.</p>
    <dl class="dl-horizontal">
      <dt>$id</dt>
      <dd>Первичный ключ поля на удаление.</dd>
    </dl>
<pre>
<code class="php">            
public function handleDeleteRow($id)
{
    // do something
    return array(
        'id'     => $id,
        'status' => true
    );
} // end handleDeleteRow
</code>
</pre> 
</li>

<li>
    <code>handleInsertRow($values)</code>
    <p>Переопределение полностью всей логики по созданию поля. Возвращаемое значение прерывает логический блок.</p>
    <dl class="dl-horizontal">
      <dt>$values</dt>
      <dd>Массив значений из формы создания.</dd>
    </dl>
<pre>
<code class="php">            
public function handleInsertRow($values)
{
    // do something
    return array(
        'id' => $idInsertedRow,
        'values' => $values
    );
} // end handleInsertRow
</code>
</pre> 
</li>

<li>
    <code>handleUpdateRow($values)</code>
    <p>Переопределение полностью всей логики по обновлению поля. Возвращаемое значение прерывает логический блок.</p>
<pre>
<code class="php">            
public function handleUpdateRow($values)
{
    // do something
    return array(
        'id' => $idUpdatedRow,
        'values' => $values
    );
} // end handleUpdateRow
</code>
</pre> 
</li>

<li>
    <code>onInsertRowData(array &$data)</code>
    <p>Переопределение логики по созданию поля. Вызывается перед валидацией и добавлении значений фильтра. Возвращаемое значение прерывает логический блок по созданию поля.</p>
    <dl class="dl-horizontal">
      <dt>$data</dt>
      <dd>Массив подготовленных значений из формы.</dd>
    </dl>
<pre>
<code class="php">            
public function onInsertRowData(array &$data)
{
    // do something
    return $idInsertedRow;
} // end handleUpdateRow
</code>
</pre> 
</li>

<li>
    <code>onUpdateRowData(array &$data)</code>
    <p>Дополнение логики по обновлению поля. Вызывается после проверки значений формы и перед их валидацией.</p>
</li>

        
<li>
    <p>Методы для определения работы поля типа <code>custom</code>.</p>    
<pre>
<code class="php">       
public function onSearchCustomFilter($formField, &$db, $value)
{
} // end onSearchCustomFilter

public function onGetCustomValue($formField, array &$row, &$postfix)
{
} // end onGetCustomValue

public function onGetCustomEditInput($formField, array &$row)
{
} // end onGetCustomEditInput
    
public function onGetCustomListValue($formField, array &$row)
{
} // end onGetCustomListValue

public function onSelectCustomValue(&$db)
{
} // end onSelectCustomValue
</code>
</pre> 
</li>

<li>
    <code>onFileUpload($file)</code>
    <p>Переопределение логики манипуляций при загрузке файла. Возвращаемое значение прерывает полностью весь блок логики по сохранению файла.</p>
    <dl class="dl-horizontal">
      <dt>$file</dt>
      <dd>Объект <code>Symfony\Component\HttpFoundation\File\UploadedFile</code> с загружаемым файлом.</dd>
    </dl>
<pre>
<code class="php">     
public function onFileUpload($file)
{
    // do something
    $data = array(
        'status'     => true, // false
        'link'       => $absolutePath,
        'short_link' => $relativePath,
    );
    return Response::json($data);
} // end onFileUpload
</code>
</pre>  
</li>


<li>
    <code>onPhotoUpload($formField, $file)</code>
    <p>Переопределение логики манипуляций при загрузке изображения. Возвращаемое значение прерывает полностью весь блок логики по сохранению и обработке изображения.</p>
<pre>
<code class="php">     
public function onPhotoUpload($formField, $file)
{
    $data = array(
        'status'     => true, // false
        'link'       => $absolutePath,
        'short_link' => $relativePath,
    );
    return Response::json($data);
} // end onPhotoUpload
</code>
</pre>  
</li>

<li>
    <code>onPhotoUploadFromWysiwyg($file)</code>
    <p>Переопределение логики загрузки изображения через WYSIWYG-редактор. Возвращаемое значение прерывает полностью весь блок логики по сохранению изображения через редактор.</p>
<pre>
<code class="php">     
public function onPhotoUploadFromWysiwyg($file)
{
    $data = array(
        'status' => true, // false
        'link'   => $absolutePath,
    );
    return Response::json($data);
} // end onPhotoUploadFromWysiwyg
</code>
</pre>  
</li>

<li>
    <code>onInsertButtonFetch($def)</code>
    <p>Переопределение логики формирования <code>html</code> для кнопки создания поля. Возвращаемое значение прерывает логический блок.</p>
    <dl class="dl-horizontal">
      <dt>$def</dt>
      <dd>Описания настроек для данной кнопки.</dd>
    </dl>
<pre>
<code class="php">     
public function onInsertButtonFetch($def)
{
    return '&lt;p&gt;hai&lt;/p&gt;';
} // end onInsertButtonFetch
</code>
</pre>  
</li>

<li>
    <code>onUpdateButtonFetch($def)</code>
    <p>Переопределение логики формирования <code>html</code> для кнопки редактирования поля. Возвращаемое значение прерывает логический блок.</p>
</li>

<li>
    <code>onDeleteButtonFetch($def)</code>
    <p>Переопределение логики формирования <code>html</code> для кнопки удаления поля. Возвращаемое значение прерывает логический блок.</p>
</li>

</ol>

