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


Table definition example:
```json
{
    "db" : {
       "table" : "settings",
       "order" : {
            "id" : "ASC"
        }
    },

    "table" : {
        "caption"     : "Settings",
        "ident"       : "settings-container",
        "form_ident"  : "settings-form",
        "table_ident" : "settings-table",
        "action"      : "/cp/handle/settings",
        "handler"     : "SettingsTableHandler"
    },

    "fast-edit" : {
        "save" : {
            "caption" : "Save"
        },
        "cancel" : {
            "caption" : "Cancel edit"
        }
    },

    "fields" : {
        "id" : {
            "caption" : "#",
            "type"    : "readonly",
            "class"   : "col-id"
        },
        "name" : {
            "caption"   : "Name",
            "type"      : "text",
            "filter"    : "text",
            "fast-edit" : "true"
        },
        "value" : {
            "caption"   : "Value",
            "type"      : "text",
            "filter"    : "text",
            "fast-edit" : "true"
        }
    },

    "filters" : {

    },

    "actions" : {
        "update" : {
            "caption" : "Update"
        },
        "delete" : {
            "caption" : "Remove"
        }
    }
}
```



Custom handler example (located at models dir):
```php
use Yaro\TableBuilder\Handlers\CustomHandler;

class SettingsTableHandler extends CustomHandler {}
```
