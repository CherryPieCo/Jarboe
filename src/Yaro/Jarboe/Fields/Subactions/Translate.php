<?php

namespace Yaro\Jarboe\Fields\Subactions;


class Translate extends AbstractSubaction
{
    
    public function fetch()
    {
        // FIXME:
        list($from, $to) = $this->getAttribute('locales');
        $caption = $this->getAttribute('caption');
        
        $data = compact('caption', 'to', 'from');
        
        return \View::make('admin::tb.subactions.translate', $data)->render();
    } // end fetch
    
}
    