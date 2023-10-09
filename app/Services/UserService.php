<?php


namespace App\Services;


use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;

class UserService
{

//    region user
    /**
     * Save new user instance to database
     * @param array $user
     * @return User
     */
    public function store(array $user): User
    {
        $save = User::create($user);

        return $save;
    }

    /**
     * Get user details by Id
     * @param $id
     * @return User
     */
    public function getUserById($id): User
    {
        return User::find($id);
    }

    /**
     * Get user details by Id
     * @param $client_id
     * @return User
     */
    public function getUserByClientId($client_id): User
    {
        return User::where('id_client',$client_id)->get()->clients;
    }

    /**
     * Get user details by email
     * @param $email
     * @return User
     */
    public function getUserByEmail($email): User
    {
        return User::where('email',$email)->clients;
    }

    /**
     * Get user details by email
     * @param $id
     * @return User
     */
    public function delete($id): User
    {
        $user = User::find($id);
        $user->deleted_at = date('Y-m-d H:i:s');
//        $user->deleted_by = \auth()->id();
        $user->save();
        return $user;

    }

    /**
     * Get user details by email
     * @param $client_id
     * @return mixed
     */


    /**
     * Update user ip address and last seen
     * @param $ip
     * @return void
     */
    public function lastSeen($ip): void
    {
        if (Auth::user()) {
            User::where('id', Auth::user()->id)->update(['last_ip' => $ip, 'last_seen' => date('Y-m-d H:i:s')]);
        }
    }

    /**
     * Update get user on line statut
     * @param $id
     * @return bool
     */
    public function isUserOnLine($id): bool
    {
        $last_seen = User::where('id', $id)->get('last_seen');
        if ($last_seen) {
            $last_seen_date = $last_seen[0]->last_seen;
            $timeFirst = strtotime($last_seen_date);
            $timeSecond = strtotime(date('Y-m-d H:i:s'));
            $differenceInSeconds = $timeSecond - $timeFirst;
            return  $differenceInSeconds <= 30;
        }
        return false;
    }

    /**
     * Check if user is online, using his last seen date given
     * @param $last_seen_date
     * @return bool
     */
    public function checkOnLineStatus($last_seen_date): bool
    {
        $timeFirst = strtotime($last_seen_date);
        $timeSecond = strtotime(date('Y-m-d H:i:s'));
        $differenceInSeconds = $timeSecond - $timeFirst;
        return $differenceInSeconds <= 30;
    }

    /**
     * Update user
     * @param $id
     * @param array $user
     * @return bool
     */

    public function update($id, array $user): bool
    {
        return User::where('id', $id)->update($user);
    }

    /**
     * Update user password
     * @param $id
     * @param $password
     * @return bool
     */

    public function updatePassword($id, $password): bool
    {
        return User::where('id', $id)->update(['password' => $password]);
    }

    /**
     * Update user password
     * @param $id
     * @param $path
     * @return bool
     */

    public function updateImage($id, $path): bool
    {
        return User::where('id', $id)->update(['profilePicturePath' => $path]);
    }

//    endregion

//    region role
    /**
     * store or update user roles
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        return Role::all();
    }

    /**
     * store or update user roles
     * @param $user_id
     * @param array $role_ids
     * @return bool
     */
    public function addRole($user_id, array $role_ids): bool
    {

        // Destroy all user role
        UserRole::where('user_id', $user_id)->delete();
        $done = [];
        foreach ($role_ids as $key => $role) {
            $done[$key] = UserRole::create(['user_id' => $user_id, 'role_id' => $role]);
        }
        return count($done) === count($role_ids);
    }

    /**
     * Get Default role #Invited
     * @return Role|bool
     */
    public function getDefaultRole(): Role|bool
    {
        $role = Role::where('title', 'Invited')->get('id');
        return count($role) ? $role[0] : false;
    }

    /**
     * Get Default role #Invited
     * @param $title
     * @return Role|bool
     */
    public function getRoleByTitle($title): Role|null
    {
        $role = Role::where('title', $title)->first();
        return count($role);
    }

    /**
     * Get user roles
     * @param $user_id
     * @return mixed
     */
    public function getUserRoles($user_id): mixed
    {
        $role= UserRole::join('roles','roles.id','user_roles.role_id')->where('user_id', $user_id)->first();
        return $role->title ?? "";
    }

    /**
     * Get user roles
     * @param $user_id
     * @return mixed
     */
    public function getUserRolesTitle($user_id): mixed
    {
        return UserRole::join('roles','roles.id','user_roles.role_id')
            ->where('user_id', $user_id)->select('roles.*')->get();
    }

    /**
     * Get user roles
     * @param $user_id
     * @return mixed
     */
    public function getUserRolesId($user_id): mixed
    {
        return UserRole::join('roles','roles.id','user_roles.role_id')
            ->where('user_id', $user_id)->select('roles.id')->get();
    }
//    endregion
}
