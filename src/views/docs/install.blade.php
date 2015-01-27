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
    // ...
),
'aliases' => array(
    // ...
    'Sentry' => 'Cartalyst\Sentry\Facades\Laravel\Sentry',
    'Image' => 'Intervention\Image\Facades\Image',
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
</code>
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


</ol>  


</div>
