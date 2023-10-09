<?php


namespace App\Services;


use App\Models\UserPermission;
use App\Models\UserRole;

class SessionService
{
    public function makeData()
    {
        $role = UserRole::join('roles','roles.id','user_roles.role_id')->where('user_id', \Auth::id())->select('roles.title')->get();
        $permission = UserPermission::join('permissions','permissions.id','user_permissions.permission_id')->where('user_id', \Auth::id())->select('permissions.title')->get();
        $permissions = [];
        $roles = [];
        foreach ($role as $value){
           array_push($roles,$value->title);
        }
        foreach ($permission as $value){
           array_push($permissions,$value->title);
        }
        session(['ROLES' => $roles]);
        session(['PERMISSIONS' => $permissions]);
    }
}
