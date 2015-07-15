<div class="well well-sm">
<h3 class="text-primary">Файловый менеджер:</h3>
                    

<p>Обычный файловый менеджер. Вызов соответствующего метода через фасад возвращает все необходимое для его отображения:</p>

<pre>
<code class="php">
$content = Jarboe::fileManager($connectorUrl);

return View::make('admin::file_manager', compact('content'));
</code>
</pre>


<dl class="dl-horizontal">
  <dt>$connectorUrl</dt>
  <dd>Ссылка на коннектор файлового менеджера.  <span class="label bg-color-blueLight pull-right">/tb/elfinder/connector</span>
  </dd>
</dl>

<hr>
<p>Как должен выглядеть метод, к которому идет обращение по ссылке (в примере описан дефолтный):</p>

<pre>
<code class="php">
$dir = Config::get('laravel-elfinder::dir');
$roots = Config::get('laravel-elfinder::roots');
if (!$roots) {
    $roots = array(
        array(
            'driver' => 'LocalFileSystem', // драйвер для доступа к файловой системе (обязательно)
            'path' => public_path() . DIRECTORY_SEPARATOR . $dir, // путь к файлам (обязательно)
            'URL' => asset($dir), // ссылка на файлы (обязательно)
            'accessControl' => Config::get('laravel-elfinder::access') // коллбек для фльтрации (опционально)
        )
    );
}

// Документация опций коннектора:
// https://github.com/Studio-42/elFinder/wiki/Connector-configuration-options
$opts = array(
    'roots' => $roots
);

$connector = new \elFinderConnector(new \elFinder($opts));
return Response::stream(function () use($connector) {
    $connector->run();
});
</code>
</pre>

</div>
