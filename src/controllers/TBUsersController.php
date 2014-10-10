<?php 

namespace Yaro\TableBuilder;

use Cartalyst\Sentry\Users\UserExistsException,
    Cartalyst\Sentry\Users\WrongPasswordException,
    Cartalyst\Sentry\Users\UserNotFoundException;

class TBUsersController extends \Controller
{

    public function showUsers()
    {
        $users  = \Sentry::findAllUsers();
        $fields = \Config::get('table-builder::users.fields');
        
        return \View::make('admin::users.users_list', compact('users', 'fields'));
    } // end showUsers
    
    public function showEditUser($id)
    {
        $user   = \Sentry::findUserById($id);
        $fields = \Config::get('table-builder::users.fields');
        
        return \View::make('admin::users.users_edit', compact('user', 'fields'));
    } // end showEditUser
    
    public function showCreateUser()
    {
        $fields = \Config::get('table-builder::users.fields');
        
        return \View::make('admin::users.users_create', compact('fields'));
    } // end showCreateUser
    
    public function doDeleteUser()
    {
        $user = \Sentry::findUserById(\Input::get('id'));
        $user->delete();
        
        return \Response::json(array(
            'status' => true
        ));
    } // end doDeleteUser
    
    public function doCreateUser()
    {
        $email     = \Input::get('email');
        $password  = \Input::get('password');
        $firstName = \Input::get('first_name');
        $lastName  = \Input::get('last_name');
        $isActivated  = \Input::has('activated');
        $isSubscribed = \Input::has('is_subscribed');

        $validator = \Validator::make(
            array(
                'email'      => $email,
                'password'   => $password,
                'first_name' => $firstName,
                'last_name'  => $lastName
            ),
            array(
                'email'      => 'required|email',
                'password'   => 'required',
                'first_name' => 'required',
                'last_name'  => 'required'
            )
        );

        if ($validator->fails()) {
            $data = array(
                'status' => false,
                'errors' => $validator->messages()->all()
            );
            return \Response::json($data);
        }

        try {
            $user = \Sentry::createUser(array(
                'email'         => $email,
                'password'      => $password,
                'first_name'    => $firstName,
                'last_name'     => $lastName,
                'activated'     => $isActivated,
                'is_subscribed' => $isSubscribed
            ));
            
			if (\Input::file('image', false)) {
				$data = $this->onUploadImage($user, \Input::file('image'));
            	$user->image = $data['short_link'];
			}
            
            $user->save();
            
            /*
            $activationCode = $user->getActivationCode();

            $mailData = array(
                'user' => array(
                    'full_name' => $user->getFullName()
                ),
                'link' => URL::to('/') . '/activate/' . $activationCode
            );

            MailTemplate::ident('activate_user')->send($email, $mailData);
            */
            return \Response::json(array(
                'status' => true,
                'id'     => $user->id,
            ));
        } catch (UserExistsException $e) {
            $data = array(
                'status' => false,
                'errors' => array(
                    'Пользователь с таким Email уже существует. Введите другой Email.'
                )
            );
            return \Response::json($data);
        }
    } // end doCreateUser
    
    public function doUploadImage()
    {
        $user = \Sentry::findUserById(\Input::get('id'));
        $file = \Input::file('image');
        
        $data = $this->onUploadImage($user, $file);
        
        return \Response::json($data);
    } // end doUploadImage
    
    private function onUploadImage($user, $file)
    {
        $extension = $file->guessExtension();
        $fileName = md5_file($file->getRealPath()) .'.'. $extension;

        $prefixPath = 'storage/user_avatars/';
        $postfixPath = $this->getPathByID($user->id);
        $destinationPath = $prefixPath . $postfixPath;
        
        $status = $file->move($destinationPath, $fileName);
        
        $data = array(
            'status'     => $status,
            'link'       => \URL::to($destinationPath . $fileName),
            'short_link' => $destinationPath . $fileName
        );
        return $data;
    } // end onUploadImage
    
    public function doUpdateUser()
    {
        $user = \Sentry::findUserById(\Input::get('id'));
        
        $validator = \Validator::make(
            array(
                'email'      => \Input::get('email'),
                'first_name' => \Input::get('first_name'),
                'last_name'  => \Input::get('last_name')
            ),
            array(
                'email'      => 'required|email',
                'first_name' => 'required',
                'last_name'  => 'required'
            )
        );
        
        if ($validator->fails()) {
            $data = array(
                'status' => false,
                'errors' => $validator->messages()->all()
            );
            return \Response::json($data);
        }
        
        $user->email      = \Input::get('email');
        $user->first_name = \Input::get('first_name');
        $user->last_name  = \Input::get('last_name');
        $user->image      = \Input::get('image', '');
        
        if (\Input::get('password')) {
            $user->password = \Input::get('password');
        }
        
        $user->is_subscribed = \Input::has('is_subscribed');
        $user->activated     = \Input::has('activated');
        
        $user->save();
        
        $data = array(
            'status' => true
        );
        return \Response::json($data);
    } // end doUpdateUser
        
    private function getPathByID($id)
    {
        $id = str_pad($id, 6, '0', STR_PAD_LEFT);
        $chunks = str_split($id, 2);
        
        return implode('/', $chunks) .'/';
    } // end getPathByID
 
}