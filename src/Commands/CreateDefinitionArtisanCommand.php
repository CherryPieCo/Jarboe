<?php

namespace Yaro\Jarboe\Commands;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;


class CreateDefinitionArtisanCommand extends Command 
{

    protected $name = 'tb:definition';
    protected $description = 'Create definition by table name.';
    
    private $table;
    private $stub;
    private $definition;
    private $getRequestUri;
    private $postRequestUri;

    public function fire()
    {
        $this->table = $this->argument('table');
        $this->stub  = file_get_contents(__DIR__ .'/../stubs/definition.stub');
        
        $fields = \DB::select(\DB::raw('SHOW FULL COLUMNS FROM '. $this->table));
        $this->doFillStub($fields);
        
        $this->doSaveStub();
        
        $this->doGenerateMethods();
    } // end fire
    
    private function doGenerateMethods()
    {
        $methodPostfix = ucfirst(camel_case(preg_replace('~2~', '_to_', $this->table)));
        $this->info('Routes:');
        $getRoute = "Route::get('". $this->trimAdminPrefix($this->getRequestUri) 
                  . "', 'TableAdminController@show". $methodPostfix ."');";
        $postRoute = "Route::post('". $this->trimAdminPrefix($this->postRequestUri) 
                  . "', 'TableAdminController@handle". $methodPostfix ."');";
        $this->line($getRoute);
        $this->line($postRoute);
        
        $this->info('Methods:');
        $showMethod = 'public function show'. $methodPostfix .'()'. PHP_EOL;
        $showMethod .= '{' . PHP_EOL;
        $showMethod .= '    $options = array(' . PHP_EOL;
        $showMethod .= "        'url'      => '". $this->getRequestUri ."'," . PHP_EOL;
        $showMethod .= "        'def_name' => '". $this->definition ."'," . PHP_EOL;
        $showMethod .= '    );' . PHP_EOL;
        $showMethod .= '    list($table, $form) = Jarboe::table($options);' . PHP_EOL . PHP_EOL;
        $showMethod .= "    return View::make('admin::table', compact('table', 'form'));" . PHP_EOL;
        $showMethod .= '} // end show'. $methodPostfix . PHP_EOL . PHP_EOL;
        echo $showMethod;
        
        $postMethod = 'public function handle'. $methodPostfix .'()'. PHP_EOL;
        $postMethod .= '{' . PHP_EOL;
        $postMethod .= '    $options = array(' . PHP_EOL;
        $postMethod .= "        'url'      => '". $this->getRequestUri ."'," . PHP_EOL;
        $postMethod .= "        'def_name' => '". $this->definition ."'," . PHP_EOL;
        $postMethod .= '    );' . PHP_EOL . PHP_EOL;
        $postMethod .= '    return Jarboe::table($options);' . PHP_EOL;
        $postMethod .= '} // end handle'. $methodPostfix . PHP_EOL;
        echo $postMethod;
    } // end doGenerateMethods
    
    private function trimAdminPrefix($uri)
    {
        $segments = array_filter(explode('/', $uri));
        array_shift($segments);

        return implode('/', $segments);
    } // end trimAdminPrefix
    
    private function doFillStub($fields)
    {
        $this->doFillGetURI();
        $this->doFillPostURI();
        
        $this->stub = preg_replace('~\%table\%~', $this->table, $this->stub);
        $this->stub = preg_replace('~\%geturi\%~', $this->getRequestUri, $this->stub);
        $this->stub = preg_replace('~\%posturi\%~', $this->postRequestUri, $this->stub);
        $this->stub = preg_replace('~\%fields\%~', $this->getFieldsTemplate($fields), $this->stub);
    } // end doFillStub 
    
    private function doFillGetURI()
    {
        $getRequestUri = trim($this->ask('Uri for GET request? (with admin panel prefix)'));
        if (!$getRequestUri) {
            $this->error('Uri for GET request is required.');
            $this->doFillGetURI();
        }

        $this->getRequestUri = $getRequestUri;
    } // end doFillGetURI
    
    private function doFillPostURI()
    {
        $postRequestUri = trim($this->ask('Uri for POST request? (with admin panel prefix)'));
        if (!$postRequestUri) {
            $this->error('Uri for POST request is required.');
            $this->doFillPostURI();
        }

        $this->postRequestUri = $postRequestUri;
    } // end doFillPostURI
    
    private function getFieldsTemplate($fields)
    {
        $template = '';
        foreach ($fields as $field) {
            if ($field['Field'] == 'id') {
                continue;
            }
            
            $this->comment($field['Field'] .':');
            if (!$this->confirm('Add field to definition? [y|n]')) {
                continue;
            }
            
            $template .= sprintf("        '%s' => array(\n", $field['Field']);
            $template .= $this->getFieldCaption($field);
            $template .= $this->getFieldType($field);
            $template .= "        ),\n";
        }
        
        // FIXME:
        $temp = '';
        $template .= $this->onManyToMany($temp, $field);

        
        return $template;
    } // end getFieldsElements
    
    private function onManyToMany(&$template = '', $field)
    {
        if (!$template && !$this->confirm('Is there many2many relation? [y|n]')) {
            return $template;
        }
        
        $template .= sprintf("        '%s' => array(\n", 'many2many_'. str_random(6));
        $template .= sprintf("            'caption' => '%s',\n", 'Связи');
        $template .= "            'type' => 'many_to_many',\n";
        $template .= $this->getManyToManyFieldType($field);
        $template .= "        ),\n";
        
        if ($this->confirm('Is there another one many2many relation? [y|n]')) {
            return $this->onManyToMany($template, $field);
        }
        
        return $template;
    } // end onManyToMany
    
    private function getManyToManyFieldType($field)
    {
        $additional = '';
        
        $showType = $this->askWithCompletion('Show type for m2m? (select2|checkbox)', array(
            'select2',
            'checkbox',
        ));
        $additional .= sprintf("            'show_type' => '%s',\n", $showType);

        
        $m2mTable = $this->ask('many2many table name? (i.e. this_table2other_table)');
        $m2mKeyField = $this->ask('many2many table foreign column to this_table? (i.e. id_this_table)');
        $m2mExternalTable = $this->ask('other_table name? (i.e. other_table)');
        $m2mExternalForeignKeyField = 'id';//$this->ask('Column that previous column referenced to? (id in most cases)');
        $m2mExternalKeyField = $this->ask('many2many table foreign column to other_table? (i.e. id_other_table)');
        $m2mExternalValueField = $this->ask('Which column to display from other_table? (i.e. name)');
        
        $additional .= sprintf("            'mtm_table'                      => '%s',\n", $m2mTable);
        $additional .= sprintf("            'mtm_key_field'                  => '%s',\n", $m2mKeyField);
        $additional .= sprintf("            'mtm_external_foreign_key_field' => '%s',\n", $m2mExternalForeignKeyField);
        $additional .= sprintf("            'mtm_external_key_field'         => '%s',\n", $m2mExternalKeyField);
        $additional .= sprintf("            'mtm_external_value_field'       => '%s',\n", $m2mExternalValueField);
        $additional .= sprintf("            'mtm_external_table'             => '%s',\n", $m2mExternalTable);
        
        return $additional;
    } // end getManyToManyFieldType
    
    private function getFieldCaption($field)
    {
        $caption = $field['Comment'] ? : $field['Field'];
        return sprintf("            'caption' => '%s',\n", $caption);
    } // end getFieldCaption
    
    private function getFieldType($field)
    {
        $type = 'text';
        $additional = '';
        // enum
        if (preg_match('~^enum\(([^\)]+)\)~', $field['Type'], $match)) {
            $type = 'select';
            
            $options = explode(',', $match[1]);
            $additional .= "            'options' => array(\n";
            foreach ($options as $option) {
                $additional .= sprintf("                %s => %s,\n", $option, $option);
            }
            $additional .= "            ),\n";
        } elseif (preg_match('~^tinyint\(1\)$~', $field['Type'], $match)) {
        // tinyint
            $type = 'select';
            
            $additional .= "            'options' => array(\n";
            $additional .= "                1 => 'Да',\n";
            $additional .= "                0 => 'Нет',\n";
            $additional .= "            ),\n";
            
            if ($field['Null'] == 'YES') {
                $additional .= "            'is_null' => true\n";
            }
        } elseif ($field['Key'] == 'MUL') {
            $type = 'foreign';
            
            $references = \DB::select(
                \DB::raw("select concat(table_name, '.', column_name) as 'fk', concat(referenced_table_name, '.', referenced_column_name) as 'ref' from information_schema.key_column_usage where referenced_table_name is not null HAVING fk = ?"), 
                array($this->table .'.'. $field['Field'])
            );
            
            // cuz one2many
            $references = $references[0];
            
            $refInfo = explode('.', $references['ref']);
            $foreignTable = $refInfo[0];
            $foreignKey   = $refInfo[1];
            
            $additional .= sprintf("            'foreign_table' => '%s',\n", $foreignTable);
            $additional .= sprintf("            'foreign_key_field' => '%s',\n", $foreignKey);
            $additional .= sprintf("            'foreign_value_field' => '%s', //change me\n", $foreignKey);
            $additional .= sprintf("            'alias' => '%s',\n", $this->table . $foreignTable);
        } elseif ($field['Field'] == 'datetime') {
            $type = 'datetime';
        } elseif ($field['Field'] == 'timestamp') {
            $type = 'timestamp';
        } elseif ($field['Type'] == 'text') {
            if ($this->confirm('WYSIWYG field? [y|n]')) {
                $type = 'wysiwyg';
                $wysiwygEditor = $this->askWithCompletion('Wysiwyg editor? (summernote|redactor)', array(
                    'summernote',
                    'redactor',
                ), 'redactor');
                $additional .= sprintf("            'wysiwyg' => '%s',\n", $wysiwygEditor);
            } elseif ($this->confirm('Textarea field? [y|n]')) {
                $type = 'textarea';
            }
        }
        
        $typeTemplate = sprintf("            'type' => '%s',\n", $type);
        $typeTemplate .= $additional;
        
        if ($this->confirm('Hide in list? [y|n]')) {
            $typeTemplate .= "            'hide_list' => true,\n";
        }
        //if ($this->confirm('Hide in form? [y|n]')) {
        //    $typeTemplate .= "            'hide_form' => true,\n";
        //}
        
        return $typeTemplate;
    } // end 
    
    private function doSaveStub()
    {
        $postfix = '';
        if (file_exists(app_path() .'/tb-definitions/'. $this->table .'.php')) {
            $postfix = '_'. time();
        }
        
        $this->definition = $this->table . $postfix;
        
        $path = app_path() .'/tb-definitions/'. $this->definition .'.php';
        file_put_contents($path, $this->stub);
    } // end doSaveStub
    
    protected function getArguments()
    {
        return array(
            array('table', InputArgument::REQUIRED, 'Table name.'),
        );
    } // end getArguments
    
    protected function getOptions()
    {
        return array(
            //
        );
    } // end getOptions    

}
