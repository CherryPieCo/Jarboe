[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Cherry-Pie/Jarboe/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Cherry-Pie/Jarboe/?branch=master)

````
php artisan config:publish --path="/workbench/yaro/jarboe/src/config" yaro/jarboe
php artisan asset:publish --bench="yaro/jarboe"
````

To app/config/app.php
```php
// ...
'Yaro\Jarboe\JarboeServiceProvider',
// ...
'Jarboe'   => 'Yaro\Jarboe\Facades\Jarboe',
'Settings' => 'Yaro\Jarboe\Helpers\Settings',
// ...
```

