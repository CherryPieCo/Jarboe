````
php artisan config:publish --path="/workbench/yaro/table-builder/src/config" yaro/table-builder

// php artisan asset:publish --bench="yaro/table-builder"
````

To app/config/app.php
```php
// ...
'Yaro\TableBuilder\TableBuilderServiceProvider',
// ...
'TableBuilder'  => 'Yaro\TableBuilder\Facades\TableBuilder',
'Settings'      => 'Yaro\TableBuilder\Helpers\Settings',
// ...
```

