<?php

namespace Yaro\Jarboe\Handlers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;


class ExportHandler 
{
    
    protected $def;
    protected $controller;

    public function __construct(array $exportDefinition, &$controller)
    {
        $this->def = $exportDefinition;
        $this->controller = $controller;
    } // end __construct
    
    public function fetch()
    {
        $def = $this->def;
        if (!$def || !$def['check']()) {
            return '';
        }
        
        $fields = array();
        foreach ($this->controller->getFields() as $field) {
            $fields[$field->getFieldName()] = $field->getAttribute('caption');
        }
        
        if (isset($this->def['handle']['list'])) {
            $listHandler = $this->def['handle']['list'];
            $listHandler($fields);
        }

        return View::make('admin::tb.export_buttons', compact('def', 'fields'));
    } // end fetch
    
    private function doCheckPermission()
    {
        if (!$this->def['check']()) {
            throw new \RuntimeException('Export not permitted');
        }
    } // end doCheckPermission
    
    public function doExportCsv($idents)
    {
        $this->doCheckPermission();
        
        // FIXME: move default to options
        $delimiter = ',';
        if (isset($this->def['buttons']['csv']['delimiter'])) {
            $delimiter = $this->def['buttons']['csv']['delimiter'];
        }
        
        
        $additional = array();
        if (isset($this->def['handle']['export']['caption'])) {
            $captionHandler = $this->def['handle']['export']['caption'];
            $additional = $captionHandler($idents);
        }
        foreach ($additional as $additionalIdent => $additionalCaption) {
            $index = array_search($additionalIdent, $idents);
            if ($index !== false) {
                unset($idents[$index]);
            }
        }
        
        $rowsHandler = false;
        if (isset($this->def['handle']['export']['rows'])) {
            $rowsHandler = $this->def['handle']['export']['rows'];
        }
        
        $csvRow = '';
        foreach ($idents as $ident) {
            $field = $this->controller->getField($ident);
            $csvRow .= '"'. $field->getAttribute('caption') .'"'. $delimiter;
        }
        foreach ($additional as $ident => $identCaption) {
            $csvRow .= '"'. $identCaption .'"'. $delimiter;
        }
        $csvRow = rtrim($csvRow, $delimiter);
        $csv = $csvRow;
        
        
        $between = $this->getBetweenValues();
        // FIXME: move to separate method, maybe
        $rows = $this->controller->query->getRows(false, true, $between, true); // without pagination & with user filters & with all fields
        if (isset($this->def['handle']['export']['filter'])) {
            $filterHandler = $this->def['handle']['export']['filter'];
            $rows = $filterHandler($rows);
        }
        foreach ($rows as $row) {
            $csvRow = "\n";
            foreach ($idents as $ident) {
                $field = $this->controller->getField($ident);
                $value = $field->getExportValue('csv', $row);
                if ($rowsHandler) {
                    $rowsHandler($row['id'], $row, $ident, $value);
                }
                $csvRow .= '"'. $value .'"'. $delimiter;
            }
            foreach ($additional as $ident => $identCaption) {
                $value = '';
                if ($rowsHandler) {
                    $rowsHandler($row['id'], $row, $ident, $value);
                }
                $csvRow .= '"'. $value .'"'. $delimiter;
            }
            $csvRow = rtrim($csvRow, $delimiter);
            $csv .= $csvRow;
        }
        
        $name = $this->getAttribute('filename', 'export');
        $this->doSendHeaders($name .'_'. date("Y-m-d") .'.csv');
        
        die($csv);
    } // end doExportCsv
    
    private function getBetweenValues()
    {
        $this->doCheckPermission();
        
        $between = array();
        if ($this->getAttribute('date_range_field')) {
            // XXX:
            $from = Input::get('d.from', '01/01/1900');
            $from = strtotime(str_replace('/', '-', $from));
            $from = date('Y-m-d', $from) .' 00:00:00';
            // XXX:
            $to = Input::get('d.$to', '01/01/2199');
            $to = strtotime(str_replace('/', '-', $to));
            $to = date('Y-m-d', $to) .' 23:59:59';
            
            $between['field'] = $this->getAttribute('date_range_field');
            $between['values'] = array(
                $from, $to
            );
        }
        
        return $between;
    } // end getBetweenValues
    
    public function doExportXls($idents)
    {
        $xls = '';
        $this->addXlsHeader($xls);
        
        $row = array();
        foreach ($idents as $ident) {
            $field = $this->controller->getField($ident);
            $row[] = $field->getAttribute('caption');
        }
        $this->addXlsRow($row, $xls);
        
        $between = $this->getBetweenValues();
        // FIXME: move to separate method, maybe
        $rows = $this->controller->query->getRows(false, false, $between); // without pagination & user filters
        foreach ($rows as $row) {
            $xlsRow = array();
            foreach ($idents as $ident) {
                $field = $this->controller->getField($ident);
                $xlsRow[] = $field->getExportValue('xls', $row);
            }
            $this->addXlsRow($xlsRow, $xls);
        }
        
        $name = $this->getAttribute('filename', 'export');
        $this->doSendHeaders($name .'_'. date("Y-m-d") .'.xls');
        
        $this->addXlsFooter($xls);
        
        die($xls);
    } // end doExportXls
    
    private function addXlsRow($row, &$xls)
    {
        $xls .= "        <Row>\n";
        foreach ($row as $value) {
            $xls .= $this->addXlsCell($value, $xls);
        }
        $xls .= "        </Row>\n";
    } // end addXlsRow
    
    private function addXlsCell($value, &$xls)
    {
        $style = '';
        
        // Tell Excel to treat as a number. Note that Excel only stores roughly 15 digits, so keep 
        // as text if number is longer than that.
        if (preg_match("/^-?\d+(?:[.,]\d+)?$/", $value) && (strlen($value) < 15)) {
            $type = 'Number';
        }
        // Sniff for valid dates; should look something like 2010-07-14 or 7/14/2010 etc. Can
        // also have an optional time after the date.
        //
        // Note we want to be very strict in what we consider a date. There is the possibility
        // of really screwing up the data if we try to reformat a string that was not actually 
        // intended to represent a date.
        else if(preg_match("/^(\d{1,2}|\d{4})[\/\-]\d{1,2}[\/\-](\d{1,2}|\d{4})([^\d].+)?$/", $value) &&
                    ($timestamp = strtotime($value)) &&
                    ($timestamp > 0) &&
                    ($timestamp < strtotime('+500 years'))) {
            $type = 'DateTime';
            $value = strftime("%Y-%m-%dT%H:%M:%S", $timestamp);
            $style = 'sDT'; // defined in header; tells excel to format date for display
        }
        else {
            $type = 'String';
        }
                
        $value = str_replace('&#039;', '&apos;', htmlspecialchars($value, ENT_QUOTES));
        $xls .= "            ";
        $xls .= $style ? "<Cell ss:StyleID=\"$style\">" : "<Cell>";
        $xls .= sprintf("<Data ss:Type=\"%s\">%s</Data>", $type, $value);
        $xls .= "</Cell>\n";
    } // end addXlsCell
    
    private function addXlsHeader(&$xls)
    {
        $xls .= "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<Workbook xmlns=\"urn:schemas-microsoft-com:office:spreadsheet\" xmlns:x=\"urn:schemas-microsoft-com:office:excel\" xmlns:ss=\"urn:schemas-microsoft-com:office:spreadsheet\" xmlns:html=\"http://www.w3.org/TR/REC-html40\">";
        
        // set up styles
        $xls .= "<Styles>\n";
        $xls .= "<Style ss:ID=\"sDT\"><NumberFormat ss:Format=\"Short Date\"/></Style>\n";
        $xls .= "</Styles>\n";
        
        // worksheet header
        $xls .= sprintf("<Worksheet ss:Name=\"%s\">\n    <Table>\n", $this->getAttribute('filename', 'export'));
    } // end addXlsHeader
        
    private function addXlsFooter(&$xls)
    {
        $xls .= "    </Table>\n</Worksheet>\n";
        $xls .= "</Workbook>";
    } // end addXlsFooter
    
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
    
}