<?php

return array(

    'view' => array(
        'list' => function(array $row) {},
        
        'form' => function(array $row) { // empty if create form
            $permissions = $permissions = config('jarboe.users.permissions', []);
            $groupPermissions = array();
            if ($row) {
                $groupPermissions = \Sentinel::findRoleById($row['id'])->permissions;
            }
            $groupPermissions = $groupPermissions ? : array();

            $data = compact('groupPermissions', 'permissions');
            return view('admin::users.patterns.group_permissions', $data);
        }, // end view
    ),
    
    'handle' => array(
        'insert' => function($idRow, $patternValues, $values) {
            $group = \Sentinel::findRoleById($idRow);
            
            foreach ($patternValues as $permissionGroup => $permissionActions) {
                foreach ($permissionActions as $permissionAction => $permission) {
                    $ident = $permissionGroup .'.'. $permissionAction;
                    switch ($permission) {
                        case 'allow':
                            $group->addPermission($ident);
                            break;
                        
                        case 'deny':
                            $group->addPermission($ident, false);
                            break;
                            
                        default:
                            $msg = 'Not allowed permission ['. $permission .'] for ['. $ident .']';
                            throw new \RuntimeException($msg);
                    }
                }
            }
            
            $group->save();
        }, // end insert
        
        'update' => function($idRow, $patternValues, $values) {
            $group = \Sentinel::findRoleById($idRow);
            
            foreach ($patternValues as $permissionGroup => $permissionActions) {
                foreach ($permissionActions as $permissionAction => $permission) {
                    $ident = $permissionGroup .'.'. $permissionAction;
                    switch ($permission) {
                        case 'allow':
                            $group->addPermission($ident);
                            break;
                        
                        case 'deny':
                            $group->addPermission($ident, false);
                            break;
                            
                        default:
                            $msg = 'Not allowed permission ['. $permission .'] for ['. $ident .']';
                            throw new \RuntimeException($msg);
                    }
                }
            }
            
            $group->save();
        }, // end update
        
        'delete' => function($idRow) {}, // end delete
    ),
    
);
