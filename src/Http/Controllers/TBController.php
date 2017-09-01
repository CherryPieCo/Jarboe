<?php 

namespace Yaro\Jarboe\Http\Controllers;

use App\Http\Controllers\Controller;
use Yaro\Jarboe\Informer;
use Illuminate\Http\Request;
use Sentinel;


class TBController extends Controller
{

    public function __construct()
    {
    } // end __construct

    public function showDashboard()
    {
        return view('admin::dashboard');
    } // end showDashboard

    public function showLogin()
    {
        if (Sentinel::check()) {
            return redirect(config('jarboe.admin.uri'));
        }
        
        return view('admin::login');
    } // end showLogin
 
    public function postLogin(Request $request)
    {
        try {
            Sentinel::authenticate(
                array(
                    'email'    => $request->get('email'), 
                    'password' => $request->get('password')
                ), 
                $request->has('rememberme')
            );
            
            $onLogin = config('jarboe.login.on_login'); 
            $onLogin();
            
            if ($request->has('is_from_locked_screen')) {
                return response()->json([
                    'status' => true
                ]);
            }
            return redirect()->intended(config('jarboe.admin.uri'));
            
        } catch (\Exception $e) {
            if ($request->has('is_from_locked_screen')) {
                return response()->json(array(
                    'status' => false,
                    'error'  => trans('jarboe::login.not_found')
                ));
            }
            
            session()->put('tb_login_not_found', trans('jarboe::login.not_found'));
            return redirect(config('jarboe.admin.uri'));
        }
    } // end 
 
    public function doLogout()
    {
        $onLogout = config('jarboe.login.on_logout');
        \Sentinel::logout();
        
        return $onLogout();
    } // end doLogout
    
    
    public function fetchByUrl(Request $request)
    {
        $url = $request->get('url');

        $embera = new \Embera\Embera();
        $info = $embera->getUrlInfo($url);
        
        $info['status'] = true;
        
        return response()->json($info);
    } // end fetchByUrl
    
    public function doEmbedToText(Request $request)
    {
        $text = $request->get('text');

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
        return response()->json($info);
    } // end doEmbedToText
    
    public function getInformNotification(Request $request)
    {
        $index = $request->get('index');
        $informer = new Informer();
        
        $data = array(
            'status' => true,
            'html'   => $informer->getContentByIndex($index)
        );
        return response()->json($data);
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
        return response()->json($data);
    } // end getInformNotificationCounts
    
    public function doSaveMenuPreference(Request $request)
    {
        
        $option = $request->get('option');
        $cookie = \Cookie::forever('tb-misc-body_class', $option);
        
        $data = array(
            'status' => true
        );
        $response = response()->json($data);
        $response->headers->setCookie($cookie);
        
        return $response;
    } // end doSaveMenuPreference
    
    public function doSaveStructureHeight(Request $request)
    {
        $option = $request->get('height');
        $cookie = cookie()->forever('tb-structure-height', $option);
        
        $response = response()->cookie($cookie)->json(['status' => true]);
        $response->headers->setCookie($cookie);
        
        
        $response->withCookie($cookie);
        
        return $response;
    } // end doSaveStructureHeight

}