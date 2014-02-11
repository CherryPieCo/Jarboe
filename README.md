To show table:
```php
$options = array(
    'def_name' => 'settings',
    'def_path' => '/views/table_definitions/',
    'tpl_path' => 'table_templates',
);
return TableBuilder::show($options);
```

For handling post actions for table:
```php
$options = array(
    'def_name' => 'settings',
    'def_path' => '/views/table_definitions/',
    'tpl_path' => 'table_templates',
);
return TableBuilder::handle($options);
```

