<p>
    Обычная <code>&lt;select&gt;&lt;/select&gt;</code>.<br>
    Дополнительные опции:
</p>

<pre>
<code class="php">
'status' => array(
    // ...
    'options' => array(
        'pending' => 'В ожидании',
        'active'  => 'Активен',
    ),
),
</code>
</pre>            

<dl class="dl-horizontal">
  <dt>options</dt>
  <dd>Опции для селекта. <span class="label bg-color-red pull-right">обязательное</span> <br>
       Ключем выступает значение, что пойдет в бд, значение элемента — его отображаемый заголовок.
  </dd>
</dl>