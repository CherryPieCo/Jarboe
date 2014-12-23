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
    // ...
    'colors' => array(
        'pending' => 'lightpink',
        'active'  => 'lightcyan',
    ),
    'is_tr_color' => true,
),
</code>
</pre>            

<dl class="dl-horizontal">
  <dt>options</dt>
  <dd>Опции для селекта. <span class="label bg-color-red pull-right">обязательное</span> <br>
       Ключем выступает значение, что пойдет в бд, значение элемента — его отображаемый заголовок.
  </dd>
  
  <dt>colors</dt>
  <dd>Цвета для <code>td</code> опции селекта. <span class="label bg-color-blueLight pull-right">ниет</span> <br>
       Ключем выступает идент опции, значение - цвет.
  </dd>
  
  <dt>is_tr_color</dt>
  <dd>Флаг для закрашивания не <code>td</code>, a <code>tr</code>. <span class="label bg-color-blueLight pull-right">false</span> <br>
       Закрашивание <code>td</code> приоритетнее, чем закрашивание <code>tr</code>.
  </dd>
</dl>