<div class="well well-sm">
<h3 class="text-primary">Инсталлим:</h3>
                    

<ol>

<li>
В <code>app/config/database.php</code> заменить на:
<pre>
<code class="php">
//
'fetch' => PDO::FETCH_ASSOC,
//
</code>
</pre>
</li>


<li>
    Запустить артизаном:<br>
<pre>
<code class="shell">
php artisan vendor:publish --provider="Cartalyst\Sentinel\Laravel\SentinelServiceProvider"
php artisan vendor:publish --provider="Yaro\Cropp\ServiceProvider"
php artisan vendor:publish --provider="Intervention\Image\ImageServiceProviderLaravel5"
php artisan migrate
</code>
</pre>
</li>


<li>
    Потом это артизаном (на все соглашаемся, если чистая лара):<br>
<pre>
<code class="shell">
php artisan jarboe:install
</code>
</li>

<li>
    Потом делаем себе юзера (или суперюзера) для входа в админ-панель:<br>
<pre>
<code class="shell">
php artisan jarboe:create-user
</code>
</li>


<li>
    Копим в самый верх <code>/app/routes.php</code>:<br>
<pre>
<code class="php">
//
Route::pattern('id', '[0-9]+');
Route::pattern('slug', '[a-z0-9-]+');

if (file_exists(app_path() .'/routes_dev.php')) {
    include app_path() .'/routes_dev.php';
}
include app_path() .'/routes_backend.php';
</code>
</li>


</ol>  


</div>
