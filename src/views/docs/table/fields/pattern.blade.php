{{--
<p><img src="{{ asset('/packages/yaro/jarboe/img/coming-soon.jpg') }}" style="width: 100%;"/></p>
--}}

<p>Внедряемые шаблончики:</p>

<pre>
<code class="php">
'pattern.example' => array(),
</code>
</pre>    

<p>Название паттерна всегда должно начинаться с <code>pattern.</code>, 
после чего идет уже наименование самого паттерна, который (в данном примере) 
находится в <code>/app/tb-definitions/patterns/example.php</code></p>

<hr>

<p>Структура паттерна:</p>
<pre>
<code class="php">
return array(

    'install' => function() {
        // пока не используется
    }, // end install
    
    'view' => function(array $row) { // $row пустой, если это форма на создание записи
        // все имена инпутов необходимо делать по шаблону - pattern[this_pattern_name][my_input_name]
        $val = $row ? $row['id'] : '';
        return '&lt;input name="pattern[example][text]" value="'. $val .'"&gt;';
    }, // end view
    
    // обработчики паттерна. в $values находятся все значения формы
    'handle' => array(
        'insert' => function($values, $idRow) {
            
        }, // end insert
        
        'update' => function($values, $idRow) {
            // dr($values);
        }, // end update
        
        'delete' => function($idRow) {
            
        }, // end delete
    ),
);
</code>
</pre>  