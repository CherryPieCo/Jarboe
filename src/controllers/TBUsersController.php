<?php 

namespace Yaro\Jarboe;

use Cartalyst\Sentry\Users\UserExistsException;
use Cartalyst\Sentry\Users\WrongPasswordException;
use Cartalyst\Sentry\Users\UserNotFoundException;


class TBUsersController extends \Controller
{

    public function showUsers()
    {
        $users  = \Sentry::findAllUsers();
        
        return \View::make('admin::users.users_list', compact('users'));
    } // end showUsers
    
    public function showEditUser($id)
    {
        $isAllow = \Config::get('jarboe::users.check.users.update');
        if (!$isAllow()) {
            \App::abort(404);
        }
        
        $user   = \Sentry::findUserById($id);
        $groups = \Sentry::findAllGroups();
        $userPermissions = $user->getPermissions();
        
        $userGroups = array();
        foreach ($user->getGroups() as $group) {
            $userGroups[] = $group->name;
        }
        
        
        $data = compact('user', 'userGroups', 'groups', 'userPermissions');
        return \View::make('admin::users.users_edit', $data);
    } // end showEditUser
    
    public function showEditGroup($id)
    {
        $isAllow = \Config::get('jarboe::users.check.groups.update');
        if (!$isAllow()) {
            \App::abort(404);
        }
        
        $group = \Sentry::findGroupById($id);
        $groupPermissions = $group->getPermissions();
        
        return \View::make('admin::users.groups_edit', compact('group', 'groupPermissions'));
    } // end showEditGroup
    
    public function showCreateUser()
    {
        $isAllow = \Config::get('jarboe::users.check.users.create');
        if (!$isAllow()) {
            \App::abort(404);
        }
        
        $groups = \Sentry::findAllGroups();
        
        return \View::make('admin::users.users_create', compact('groups'));
    } // end showCreateUser
    
    public function showCreateGroup()
    {
        $isAllow = \Config::get('jarboe::users.check.groups.create');
        if (!$isAllow()) {
            \App::abort(404);
        }
        
        return \View::make('admin::users.groups_create');
    } // end showCreateGroup
    
    public function doCreateGroup()
    {
        $isAllow = \Config::get('jarboe::users.check.groups.create');
        if (!$isAllow()) {
            \App::abort(404);
        }
        
        $permissions = $this->getPermissions(\Input::get('permissions', array()));
        $total = 0;
        $perms = \Config::get('jarboe::users.permissions', array());
        foreach ($perms as $perm) {
            $total += count($perm['rights']);
        }
        
        if ($total != count($permissions) || !\Input::get('name')) {
            return \Response::json(array(
                'status' => false,
                'errors' => array(
                    'Необходимо заполнить все поля'
                )
            ));
        }
        
        try {
            $group = \Sentry::createGroup(array(
                'name'        => \Input::get('name'),
                'permissions' => $permissions,
            ));
            $data = array(
                'status' => true,
                'id'     => $group->id,
            );
        } catch (\Cartalyst\Sentry\Groups\GroupExistsException $e) {
            $data = array(
                'status' => false,
                'errors' => array(
                    'Группа уже существует'
                )
            );
        }
        
        return \Response::json($data);
    } // end doCreateGroup
    
    public function doDeleteUser()
    {
        $isAllow = \Config::get('jarboe::users.check.users.delete');
        if (!$isAllow()) {
            \App::abort(404);
        }
        
        $user = \Sentry::findUserById(\Input::get('id'));
        $user->delete();
        
        return \Response::json(array(
            'status' => true
        ));
    } // end doDeleteUser
    
    public function doCreateUser()
    {
        $isAllow = \Config::get('jarboe::users.check.users.create');
        if (!$isAllow()) {
            \App::abort(404);
        }
        
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
            $permissions = $this->getPermissions(\Input::get('permissions', array()));
            $user = \Sentry::createUser(array(
                'email'         => $email,
                'password'      => $password,
                'first_name'    => $firstName,
                'last_name'     => $lastName,
                'activated'     => $isActivated,
                'is_subscribed' => $isSubscribed,
                'permissions'   => $permissions,
            ));
            
            if (\Input::file('image', false)) {
                $data = $this->onUploadImage($user, \Input::file('image'));
                $user->image = $data['short_link'];
            }
            $user->save();
            
            $groupIDs = array_keys(\Input::get('groups', array()));
            $this->onAddGroupToUser($user, $groupIDs);

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
    
    private function onAddGroupToUser($user, $groupIDs)
    {
        $allGroups = \Sentry::findAllGroups();
        foreach ($allGroups as $group) {
            $flushGroup = \Sentry::findGroupById($group->id);
            $user->removeGroup($flushGroup);
        }
        
        foreach ($groupIDs as $id) {
            $group = \Sentry::findGroupById($id);
            $user->addGroup($group);
        }
    } // end onAddGroupToUser
    
    private function getPermissions($perms)
    {
        $prepared = array();
        foreach ($perms as $ident => $permissions) {
            foreach ($permissions as $type => $permission) {
                $permIdent = $ident .'.'. $type;
                $prepared[$permIdent] = $permission;
            }
        }
        
        return $prepared;
    } // end getPermissions
    
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
        $isAllow = \Config::get('jarboe::users.check.users.update');
        if (!$isAllow()) {
            \App::abort(404);
        }
        
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
        
        $user->permissions = $this->getPermissions(\Input::get('permissions', array()));
        
        $groupIDs = array_keys(\Input::get('groups', array()));
        $this->onAddGroupToUser($user, $groupIDs);
        
        $user->save();
        
        $data = array(
            'status' => true
        );
        return \Response::json($data);
    } // end doUpdateUser
        
    public function doUpdateGroup()
    {
        $isAllow = \Config::get('jarboe::users.check.groups.update');
        if (!$isAllow()) {
            \App::abort(404);
        }
        
        $permissions = $this->getPermissions(\Input::get('permissions', array()));
        $total = 0;
        $perms = \Config::get('jarboe::users.permissions', array());
        foreach ($perms as $perm) {
            $total += count($perm['rights']);
        }
        
        if ($total != count($permissions) || !\Input::get('name')) {
            return \Response::json(array(
                'status' => false,
                'errors' => array(
                    'Необходимо заполнить все поля'
                )
            ));
        }
        
        $group = \Sentry::findGroupById(\Input::get('id'));
        
        $group->permissions = $permissions;
        $group->name = \Input::get('name');
        
        $group->save();
        
        $data = array(
            'status' => true,
        );
        return \Response::json($data);
    } // end doUpdateGroup
        
    private function getPathByID($id)
    {
        $id = str_pad($id, 6, '0', STR_PAD_LEFT);
        $chunks = str_split($id, 2);
        
        return implode('/', $chunks) .'/';
    } // end getPathByID
 
}