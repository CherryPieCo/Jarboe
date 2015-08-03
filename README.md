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



```php
Route::any('/storage/image', 'TableAdminController@showImageStorage');
//..
public function showImageStorage()
{
    if (Request::isMethod('post')) {
        $options = array(
            'url'      => Request::path(),
            'def_name' => 'settings',
        );
        return Jarboe::table($options);
    }
    return View::make('admin::image_storage');
} // end showImageStorage
```

# License
MIT with additional restrictions:
1. Application should prise the cats.
2. SmartAdmin Responsive template must be bought.