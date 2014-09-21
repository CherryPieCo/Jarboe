<?php 

namespace Yaro\TableBuilder;


class TBController extends \Controller
{

    public function fetchByUrl()
    {
        $url = \Input::get('url');

        $embera = new \Embera\Embera();
        $info = $embera->getUrlInfo($url);
        
        $info['status'] = true;
        
        return \Response::json($info);
    } // end fetchByUrl
    
    public function doEmbedToText()
    {
        $text = \Input::get('text');

        $config = array(
            'params' => array(
                'width'  => 640,
                'height' => 360
            )
        );
        $embera = new \Embera\Embera($config);
        $res = $embera->autoEmbed($text);
        
        $info = array(
            'status' => true,
            'html' => $res
        );
        return \Response::json($info);
    } // end doEmbedToText

}