
<p class="alert alert-warning">Формирование кастомного поля довольно сырое. Предложения приветствуются.</p>

<p>
    Иногда перед нами ставят задачи, которые не <abbr title="на этом моменте бывшие разработчики альфабанка и сушии должны разразиться смехом и спросить: 'нахуа?'.">решить элегантно</abbr>.<br>
    Поэтому у нас есть кастомное поле, в которое мы можем впихнуть все что душе угодно:
</p>
    
<pre>
<code class="php">
'custom' => array(
    'caption' => 'Кастомное поле',
    'type'    => 'custom',
)
</code>
</pre>            
    
<p>Откуда берутся значения и представление для него? Куда оно записывается, и записывается ли вообще?</p>
<p>Это мы все описываем в переопределенной паре методов нашего хендлера:</p>

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

    
<dl class="dl-horizontal">
  <dt>onSearchCustomFilter</dt>
  <dd>Разруливаете поиск по своему полю.</dd>
  <dt>onGetCustomValue</dt>
  <dd>Получение значения поля.</dd>
  <dt>onGetCustomEditInput</dt>
  <dd>Возвращаемый <code>html</code> отображается в формах создания и редактирования.</dd>
  <dt>onGetCustomListValue</dt>
  <dd>Возвращаемое значение отображается в таблице.</dd>
  <dt>onSelectCustomValue</dt>
  <dd>Для изменения выборки.</dd>
</dl>

