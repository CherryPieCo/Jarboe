<?php

namespace Yaro\Jarboe;


class DefinitionMaker
{
    
    protected $table;
    protected $stub;
    
    public function __construct($table)
    {
        $this->table = $table;
        $this->stub  = file_get_contents(__DIR__ .'/stubs/definition.stub');
    } // end __construct
    
    public function create()
    {
        $fields = \DB::select(\DB::raw('SHOW FULL COLUMNS FROM '. $this->table));
        
        $this->doFillStub($fields);
        
        $this->doSaveStub();
        
        return $fields;
    } // end create
    
    private function doFillStub($fields)
    {
        $this->stub = preg_replace('~\%table\%~', $this->table, $this->stub);
        $this->stub = preg_replace('~\%fields\%~', $this->getFieldsTemplate($fields), $this->stub);
    } // end doFillStub 
    
    private function getFieldsTemplate($fields)
    {
        $template = '';
        foreach ($fields as $field) {
            if ($field['Field'] == 'id') {
                continue;
            }
            
            $template .= sprintf("        '%s' => array(\n", $field['Field']);
            $template .= $this->getFieldCaption($field);
            $template .= $this->getFieldType($field);
            $template .= "        ),\n";
        }
        
        return $template;
    } // end getFieldsElements
    
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
        }
        
        $typeTemplate = sprintf("            'type' => '%s',\n", $type);
        $typeTemplate .= $additional;
        
        return $typeTemplate;
    } // end 
    
    private function doSaveStub()
    {
        $postfix = '';
        if (file_exists(app_path() .'/tb-definitions/'. $this->table .'.php')) {
            $postfix = '_'. time();
        }
        
        $path = app_path() .'/tb-definitions/'. $this->table . $postfix .'.php';
        file_put_contents($path, $this->stub);
    } // end doSaveStub
    
}
