<dl>
  <dt class="text-primary">Как передать в описание таблицы свои значения?</dt>
  <dd>
    При создании таблицы нужно передать опцию <code>additional</code>, содержимое которой будет доступно в переменной <code>$options</code> внутри описания.
<pre>
<code class="php">            
$options = array(
    // ...
    'additional' => array(
        'var' => 'some'
    )
);
list($table, $form) = Jarboe::table($options);
</code>
</pre>  
  </dd>
  
</dl>