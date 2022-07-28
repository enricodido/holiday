<?php
/**
 * Created by PhpStorm.
 * User: andrea
 * Date: 30/10/2018
 * Time: 15:51
 */

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Route;

class Helper
{

    public static function permissionTo($name)
    {

        if (Auth::user()->hasRole(Acl::ROLE_ADMIN))
            return true;

        //Array
        if (is_array($name)) {
            $data = [];
            foreach ($name as $item) {
                array_push($data, Acl::OPERATION_R.'_'.$item);
            }
            return (Auth::user()->hasAnyPermission($data));
        }

        //String
        $data = Acl::OPERATION_R.'_'.$name;
        return (Auth::user()->hasPermissionTo($data));
    }

    public static function isRoute($name)
    {
        foreach ($name as $n) {
            if (Route::is($n)) return true;
        }
        return false;
    }

    public static function roles()
    {
        return Role::whereNotIn('name', [Acl::ROLE_SUPERADMIN,Acl::ROLE_ADMIN])->get();
    }

    public static function checkMenuActive($menu)
    {
        switch ($menu) {
            case config('menus.user'):
                if (Route::is('users.*')
                    || Route::is('roles.*'))
                    return true;
                break;
        }

        return false;
    }

}
