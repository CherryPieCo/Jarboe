<?php

namespace Yaro\TableBuilder\Handlers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;


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
    
    public function doCsvTemplateDownload()
    {
        $this->doCheckPermission();
        
        // FIXME: move default to options
        $delimiter = ',';
        if (isset($this->def['files']['csv']['delimiter'])) {
            $delimiter = $this->def['files']['csv']['delimiter'];
        }
        
        $csv = '';
        $primaryKey = $this->getAttribute('pk');
        foreach ($this->def['fields'] as $field => $caption) {
            if (!$primaryKey) {
                $primaryKey = $field;
            }
            
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
        if (!$def['check']()) {
            throw new \RuntimeException('Import not permitted');
        }
    } // end doCheckPermission
    
}