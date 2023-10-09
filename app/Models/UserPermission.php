<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'permission_id',
    ];

    public static function getPermission() : array | null
    {
        return session('PERMISSIONS');
    }

    public static function checkPermission($permission): bool
    {
        return in_array($permission,session('PERMISSIONS'))  ;
    }
}
