<p>
    WYSIWYG-редактор. <br>
    Сейчас используется кастомный <a href="http://summernote.org/" target="_blank">Summernote</a>, со временем добавятся и другие, если будет необходимо.<br>
    Дополнительные опции:<br>
    
    <pre>
    <code class="php">
    'description' => array(
        'caption' => 'Desc',
        'type'    => 'wysiwyg',
        'wysiwyg' => 'redactor',
        'editor-options' => array(
            'lang' => 'ru-RU',
        ),
    )
    </code>
    </pre>   
    <dl class="dl-horizontal">
      <dt>wysiwyg</dt>
      <dd>Тип висивига (<code>summernote|redactor</code>). <span class="label bg-color-blueLight pull-right">summernote</span></dd>
      <dt>editor-options</dt>
      <dd>Перечень настроек редактора для инициализации (<code>summernote</code>). <span class="label bg-color-blueLight pull-right">без них</span></dd>
    </dl>
</p>