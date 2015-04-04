<?php

namespace Yaro\Jarboe\Handlers;

use Yaro\Jarboe\Exceptions\JarboeValidationException;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;


class ImportHandler 
{
    
    protected $def;
    protected $controller;

    public function __construct(array $importDefinition, &$controller)
    {
        $this->def = $importDefinition;
        $this->controller = $controller;
    } // end __construct
    
    public function fetch()
    {
        $def = $this->def;
        if (!$def || !$def['check']()) {
            return '';
        }

        return View::make('admin::tb.import_buttons', compact('def'));
    } // end fetch
    
    public function doImportCsv($file)
    {
        $this->doCheckPermission();
        
        $definition = $this->controller->getDefinition();
        $table = $definition['db']['table'];
        
        // FIXME: move default to options
        $delimiter = ',';
        if (isset($this->def['files']['csv']['delimiter'])) {
            $delimiter = $this->def['files']['csv']['delimiter'];
        }
        
        reset($this->def['fields']);
        $primaryKey = $this->getAttribute('pk', key($this->def['fields']));
        
        $handle = fopen($file->getRealPath(), 'r');
        $fields = array();
        $n = 1;
        while ($row = fgetcsv($handle, 0, $delimiter)) {
            if ($n === 1) {
                foreach ($row as $key => $rowCaption) {
                    foreach ($this->def['fields'] as $ident => $fieldCaption) {
                        if ($rowCaption === $fieldCaption) {
                            $fields[$key] = $ident;
                        }
                    }
                }
                $n++;
                continue;
            }
            
            if (count($row) != count($fields)) {
                if (is_null($row[0])) {
                    $message = 'Пустые строки недопустимы для csv формата. Строка #'. $n;
                } else {
                    $message = 'Не верное количество полей. Строка #'. $n .': '
                             . count($row) .' из '. count($fields);
                }
                throw new JarboeValidationException($message);
            }
            
            $updateData = array();
            $pkValue = '';
            foreach ($fields as $key => $ident) {
                if ($ident == $primaryKey) {
                    $pkValue = $row[$key];
                    continue;
                }
                $updateData[$ident] = $row[$key];
            }
            if (!$pkValue) {
                throw new JarboeValidationException('Ключ для обновления не установлен.');
            }
            
            DB::table($table)->where($primaryKey, $pkValue)->update($updateData);
            
            $n++;
        }
        
        return true;
        //$this->doCheckFields();
    } // end doImportCsv
    
    public function doCsvTemplateDownload()
    {
        $this->doCheckPermission();
        
        // FIXME: move default to options
        $delimiter = ',';
        if (isset($this->def['files']['csv']['delimiter'])) {
            $delimiter = $this->def['files']['csv']['delimiter'];
        }
        
        $csv = '';
        foreach ($this->def['fields'] as $field => $caption) {
            $csv .= '"'. $caption .'"'. $delimiter;
        }
        // remove extra tailing delimiter
        $csv = rtrim($csv, $delimiter);
        
        $name = $this->getAttribute('filename', 'import_template');
        $this->doSendHeaders($name .'_'. date("Y-m-d") .'.csv');
        
        die($csv);
    } // end doCsvTemplateDownload
    
    private function doSendHeaders($filename)
    {
        // disable caching
        $now = gmdate('D, d M Y H:i:s');
        header('Expires: Tue, 03 Jul 2001 06:00:00 GMT');
        header('Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate');
        header('Last-Modified: '. $now .' GMT');
    
        // force download  
        header('Content-Type: application/force-download');
        header('Content-Type: application/octet-stream');
        header('Content-Type: application/download');
    
        // disposition / encoding on response body
        header('Content-Disposition: attachment;filename='. $filename);
        header('Content-Transfer-Encoding: binary');
    } // end doSendHeaders
    
    private function getAttribute($ident, $default = false)
    {
        return isset($this->def[$ident]) ? $this->def[$ident] : $default;
    } // end getAttribute
    
    private function doCheckPermission()
    {
        if (!$this->def['check']()) {
            throw new \RuntimeException('Import not permitted');
        }
    } // end doCheckPermission
    
}