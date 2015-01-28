<?php 

namespace Yaro\TableBuilder;


class TBController extends \Controller
{

    public function showDashboard()
    {
        return \View::make('admin::dashboard');
    } // end showDashboard

    public function showLogin()
    {
        if (\Sentry::check()) {
            return \Redirect::to(\Config::get('table-builder::admin.uri'));
        }
        
        return \View::make('admin::vis-login');
    } // end showLogin
 
    public function postLogin()
    {
        try {
            \Sentry::authenticate(
                array(
                    'email'    => \Input::get('email'), 
                    'password' => \Input::get('password')
                ), 
                \Input::has('rememberme')
            );
            
            $onLogin = \Config::get('table-builder::login.on_login'); 
            $onLogin();
            
            return \Redirect::intended(\Config::get('table-builder::admin.uri'));
            
        } catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {
            \Session::put('tb_login_not_found', \Lang::get('table-builder::login.not_found'));
            return \Redirect::to(\Config::get('table-builder::admin.uri'));
        }
    } // end 
 
    public function doLogout()
    {
        $onLogout = \Config::get('table-builder::login.on_logout');
        \Sentry::logout();
        
        return $onLogout();
    } // end doLogout
    
    
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
    
    public function getInformNotification()
    {
        $index = \Input::get('index');
        $informer = new Informer();
        
        $data = array(
            'status' => true,
            'html'   => $informer->getContentByIndex($index)
        );
        return \Response::json($data);
    } // end getInformNotification
    
    public function getInformNotificationCounts()
    {
        $informer = new Informer();
        list($total, $counts) = $informer->getCounts();
        
        $data = array(
            'status' => true,
            'total'  => $total,
            'counts' => $counts,
        );
        return \Response::json($data);
    } // end getInformNotificationCounts
    
    public function doSaveMenuPreference()
    {
        $option = \Input::get('option');
        $cookie = \Cookie::forever('tb-misc-body_class', $option);
        
        $data = array(
            'status' => true
        );
        $response = \Response::json($data);
        $response->headers->setCookie($cookie);
        
        return $response;
    } // end doSaveMenuPreference

}