<p>
    Да-да, это чекбокс.<br>
    Дополнительные опции:
</p>

<pre>
<code class="php">
'is_active' => array(
    // ...
    'is_null' => true,
),
</code>
</pre>            

<dl class="dl-horizontal">
  <dt>is_null</dt>
  <dd>Флаг для обозначения, что не выбранный чекбокс должен записаться в бд как <code>NULL</code>, иначе запишется <code>0</code>.  <span class="label bg-color-blueLight pull-right">false</span>
  </dd>
</dl>