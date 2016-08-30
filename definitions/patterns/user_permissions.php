<?php

return array(
    
    'view' => array(
        'list' => function(array $row) {
            // make all inputs with names - pattern[this_pattern_name][my_input_name]
            return 'pats';
        },
        'form' => function(array $row) { // empty if create form
            // make all inputs with names - pattern[this_pattern_name][my_input_name]
            $permissions = $permissions = config('jarboe.c.users.permissions', []);
            $userPermissions = array();
            if ($row) {
                $userPermissions = \Sentinel::findById($row['id'])->permissions;
            }
            $userPermissions = $userPermissions ? : array();

            $data = compact('userPermissions', 'permissions');
            return view('jarboe.c.users::patterns.user_permissions', $data);
        }, // end view
    ),
    
    'handle' => array(
        'insert' => function($idRow, $patternValues, $values) {
            $user = \Sentinel::findById($idRow);
            
            foreach ($patternValues as $permissionGroup => $permissionActions) {
                foreach ($permissionActions as $permissionAction => $permission) {
                    $ident = $permissionGroup .'.'. $permissionAction;
                    switch ($permission) {
                        case 'allow':
                            $user->addPermission($ident);
                            break;
                        
                        case 'deny':
                            $user->addPermission($ident, false);
                            break;
                            
                        case 'remove':
                            $user->removePermission($ident);
                            break;
                            
                        default:
                            $msg = 'Not allowed permission ['. $permission .'] for ['. $ident .']';
                            throw new \RuntimeException($msg);
                    }
                }
            }
            
            $user->save();
        }, // end insert
        
        'update' => function($idRow, $patternValues, $values) {
            $user = \Sentinel::findById($idRow);
            
            foreach ($patternValues as $permissionGroup => $permissionActions) {
                foreach ($permissionActions as $permissionAction => $permission) {
                    $ident = $permissionGroup .'.'. $permissionAction;
                    switch ($permission) {
                        case 'allow':
                            $user->addPermission($ident);
                            break;
                        
                        case 'deny':
                            $user->addPermission($ident, false);
                            break;
                            
                        case 'remove':
                            $user->removePermission($ident);
                            break;
                            
                        default:
                            $msg = 'Not allowed permission ['. $permission .'] for ['. $ident .']';
                            throw new \RuntimeException($msg);
                    }
                }
            }
            
            $user->save();
        }, // end update
        
        'delete' => function($idRow) {}, // end delete
    ),
    
);
