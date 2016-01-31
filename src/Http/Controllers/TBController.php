<?php 

namespace Yaro\Jarboe\Http\Controllers;

use App\Http\Controllers\Controller;
use Yaro\Jarboe\Informer;


class TBController extends Controller
{

    public function __construct()
    {
        $params = array(
            'only' => array(
                'postLogin',
            )
        );
        $this->beforeFilter('csrf', $params);
    } // end __construct

    public function showDashboard()
    {
        return view('admin::dashboard');
    } // end showDashboard

    public function showLogin()
    {
        if (\Sentinel::check()) {
            return \Redirect::to(config('jarboe.admin.uri'));
        }
        
        return view('admin::login');
    } // end showLogin
 
    public function postLogin()
    {
        try {
            \Sentinel::authenticate(
                array(
                    'email'    => \Input::get('email'), 
                    'password' => \Input::get('password')
                ), 
                \Input::has('rememberme')
            );
            
            $onLogin = config('jarboe.login.on_login'); 
            $onLogin();
            
            if (\Input::has('is_from_locked_screen')) {
                return \Response::json(array(
                    'status' => true
                ));
            }
            return \Redirect::intended(config('jarboe.admin.uri'));
            
        } catch (\Cartalyst\Sentinel\Users\UserNotFoundException $e) {
            if (\Input::has('is_from_locked_screen')) {
                return \Response::json(array(
                    'status' => false,
                    'error'  => trans('jarboe::login.not_found')
                ));
            }
            
            \Session::put('tb_login_not_found', trans('jarboe::login.not_found'));
            return \Redirect::to(config('jarboe.admin.uri'));
        }
    } // end 
 
    public function doLogout()
    {
        $onLogout = config('jarboe.login.on_logout');
        \Sentinel::logout();
        
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
    
    public function doSaveStructureHeight()
    {
        $option = \Input::get('height');
        $cookie = \Cookie::forever('tb-structure-height', $option);
        
        $response = \Response::json(['status' => true]);
        $response->headers->setCookie($cookie);
        
        return $response;
    } // end doSaveStructureHeight

}