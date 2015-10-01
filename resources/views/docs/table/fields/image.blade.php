<p>
                Поле типа <code>image</code>.<br>
                Имеет два вида отображения и функционрования:<br><br>
                1. Опции для единичной загрузки изображения:
            </p>
<pre>
<code class="php">
'image' => array(
    // ...
    'cropp' => false,
    'img_attributes' => array(
        'ru' => array(
            'caption' => 'ru',
            'inputs' => array(
                'oh' => array(
                    'caption' => 'Oh',
                    'type' => 'text',
                ),
                'hai' => array(
                    'caption' => 'Oh',
                    'type' => 'text',
                ),
            ),
        ),
        'en' => array(
            'caption' => 'en',
            'inputs' => array(
                'oh' => array(
                    'caption' => 'Oh',
                    'type' => 'text',
                ),
                'hai' => array(
                    'caption' => 'Oh',
                    'type' => 'text',
                ),
            ),
        ),
    ),
),
</code>
</pre>            
            
        <dl class="dl-horizontal">
          <dt>cropp</dt>
          <dd>Создавать ли превью с помощью Cropp (<code>fit(50, 50)</code>).  <span class="label bg-color-blueLight pull-right">true</span></dd>
        
          <dt>img_attributes</dt>
          <dd>Инпуты для <code>info</code> блока изображения.  <span class="label bg-color-blueLight pull-right">array</span></dd>
        
        </dl>
            
        <p>Изображение сохранится в <code>JSON</code></p>
<pre>
<code class="json">
{  
   "sizes":{  
      "original":"storage\/tb-example\/2015\/09\/25\/3953bb1ab77be01ff0622c4dd053ce7e_1443218030.jpeg"
   }
}
</code>
</pre>  
            
            <hr>
            
            <p>2. Доп.опции для множественной загрузки изображений:</p>
<pre>
<code class="php">
'images' => array(
    // ...
    'is_multiple' => true,
),
</code>
</pre>            
            
            <dl class="dl-horizontal">
              <dt>is_multiple</dt>
              <dd>Флаг для указания, что используется множественная загрузка.  <span class="label bg-color-blueLight pull-right">false</span></dd>
            </dl>    
            
             
            <p>Изображения сохранится в <code>JSON</code>, но немного иначе</p>
<pre>
<code class="json">
[  
   {  
      "sizes":{  
         "original":"storage\/tb-example\/2015\/09\/25\/744581173df42b1998f12a42555049a0_1443217009.jpeg"
      },
      "info":{  
         "ru":{  
            "alt": "oh",
            "title": "hai"
         },
         "en":{  
            "alt": "well",
            "title": "done"
         }
      }
   }, 
   {  
      "sizes":{  
         "original":"storage\/tb-example\/2015\/09\/25\/744581173df42b1998f12a42555049a0_1443217009.jpeg"
      },
      "info":{  
         "ru":{  
            "alt": "such",
            "title": "wow"
         },
         "en":{  
            "alt": "amazing",
            "title": "stuff"
         }
      }
   }
]
</code>
</pre>             
            
            <hr>
            
            <p>Также есть возможность сохранять дополнительные версии загружаемого изображения.<br>
               Пример!<br>
               Сделаем миниатюру загружаемой фотки серой и пиксельной, да еще и качество урежим чутка:
            </p>
<pre>
<code class="php">
'image' => array(
    // ...
    'variations' => array(
        'thumb' => array(
            'resize'    => array(30, 20),
            'greyscale' => array(),
            'pixelate'  => array(12)
        )
    ),
    'quality' => 90
),
</code>
</pre>              
                    <dl class="dl-horizontal">
                      <dt>variations</dt>
                      <dd>Список дополнительных вариантов загружаемого изображения.  <span class="label bg-color-blueLight pull-right">будет только original</span><br>
                          Ключем мы задаем идентификатор варианта изображения. В значении перечисляем методы с массивом передаваемых в них значений (<a target="_blank" href="http://image.intervention.io/">список всех методов</a>).
                      </dd>
                      <dt>quality</dt>
                      <dd>Качество сохраненных изображений.  <span class="label bg-color-blueLight pull-right">100</span><br>
                      </dd>
                    </dl>    


                        <p>В итоге мы получим:</p>
<pre>
<code class="json">
{  
   "sizes":{  
      "original":"storage\/tb-example\/2015\/09\/25\/3953bb1ab77be01ff0622c4dd053ce7e_1443218030.jpeg",
      "thumb": "storage\/tb-example\/2015\/09\/25\/3953bb1ab77be01ff0622c4dd053ce7e_1443218030_thumb.jpeg"
   }
}
</code>
</pre>   
                    <p>Аналогично и для множественной загрузки.</p>
                    <hr>
            
            
            <p class="alert alert-info">Описание удобного доставания изображений смотреть во вкладке трейтов.</p>
            