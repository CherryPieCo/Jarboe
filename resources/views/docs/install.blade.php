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
    В <code>app/config/app.php</code> вписать следующее:<br>
<pre>
<code class="php">
//
'providers' => array(
    // ...
    'Cartalyst\Sentry\SentryServiceProvider',
    'Intervention\Image\ImageServiceProvider',
    'Radic\BladeExtensions\BladeExtensionsServiceProvider',
    'Spatie\Glide\GlideServiceProvider',
    'Yaro\Mecha\MechaServiceProvider',
    // ...
),
'aliases' => array(
    // ...
    'Sentry' => 'Cartalyst\Sentry\Facades\Laravel\Sentry',
    'Image' => 'Intervention\Image\Facades\Image',
    'GlideImage' => 'Spatie\Glide\GlideImageFacade',
    'Mecha' => 'Yaro\Mecha\Facades\Mecha',
    // ...
),
//
</code>
</pre>

</li>

<li>
    Запустить артизаном:<br>
<pre>
<code class="shell">
php artisan migrate --package=cartalyst/sentry
php artisan config:publish cartalyst/sentry
php artisan config:publish intervention/image
php artisan config:publish yaro/laravel-glide
php artisan asset:publish yaro/mecha
// или если сабмодуль
php artisan migrate --path="workbench/yaro/jarboe/vendor/cartalyst/sentry/src/migrations"  --package=cartalyst/sentry
php artisan config:publish --path="workbench/yaro/jarboe/vendor/cartalyst/sentry/src/config" cartalyst/sentry
php artisan config:publish --path="workbench/yaro/jarboe/vendor/intervention/image/src/config" intervention/image
php artisan config:publish --path="workbench/yaro/jarboe/vendor/yaro/laravel-glide/src/config" spatie/laravel-glide
php artisan asset:publish --path="workbench/yaro/jarboe/vendor/yaro/mecha/public" yaro/mecha
</code>
</pre>
</li>

<li>
    Правим конфиг <code>app/config/packages/spatie/laravel-glide/config.php</code><br>
<pre>
<code class="php">
//...
'source' => [
    'path' => public_path(),
],
//...
'cache' => [
    'path' => public_path() .'/glidecache',
],
//...
</code>
</pre>
</li>

<li>
    Потом это артизаном (на все соглашаемся, если чистая лара):<br>
<pre>
<code class="shell">
php artisan tb:prepare
</code>
</li>

<li>
    Потом делаем себе юзера (или суперюзера) для входа в админ-панель:<br>
<pre>
<code class="shell">
php artisan tb:create-admin-user
php artisan tb:create-superuser
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

<li>
    Если ставили дерево, то идем в <code>HomeController.php</code> и экстендим его (как и все классы, в которых нужны ноды дерева):<br>
<pre>
<code class="php">
&lt;?php

class HomeController extends Yaro\Jarboe\TreeController 
{
    public function showPage()
    {
        return $this->node->title .' @ '. $this->node->getUrl();
    } // end showPage
}
</code>
</li>

</ol>  


</div>
