<?php


namespace App\Services;


class RoleService
{
    public static function canValidate() : bool
    {
        return in_array('Secretary',  session('ROLES')) || in_array('President',  session('ROLES'));
    }
}
