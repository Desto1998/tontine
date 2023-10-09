<?php


namespace App\Services;


use App\Models\Permission;
use App\Models\UserPermission;

class PermissionService
{
    /**
     * store or update user roles
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        return Permission::all();
    }

    /**
     * Store user permission
     * @param $permission_ids
     * @param $user_id
     * @return bool
     */
    public function storeUserPermission($user_id,$permission_ids ) : bool
    {
        // destroy all users permission first
        UserPermission::where('user_id',$user_id)->delete();

        $store= [];
        foreach ($permission_ids as $key => $id){
            $store[$key] = UserPermission::create([
                'user_id' => $user_id,
                'permission_id' => $id,
            ]);
        }
        return count($store) === count($permission_ids);
    }

    /**
     * get user permission
     * @param $user_id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUserPermissions($user_id): \Illuminate\Database\Eloquent\Collection
    {
        return Permission::join('user_permissions','user_permissions.permission_id','permissions.id')
            ->where('user_id',$user_id)->select('permissions.*')->get();
    }

    /**
     * get user permission title
     * @param $user_id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUserPermissionsTitle($user_id): \Illuminate\Database\Eloquent\Collection
    {
        return Permission::join('user_permissions','user_permissions.permission_id','permissions.id')
            ->where('user_id',$user_id)->select('permissions.title')->get();
    }

    /**
     * get user permission id
     * @param $user_id
     * @return array
     */
    public function getUserPermissionsIds($user_id): array
    {
        $ids =  Permission::join('user_permissions','user_permissions.permission_id','permissions.id')
            ->where('user_id',$user_id)->select('permissions.id')->get();
        $tabID = [];
        foreach ($ids as $id){
          array_push($tabID,$id->id);
        }
        return $tabID;
    }
}
