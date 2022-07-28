<?php

namespace App\Helpers;

use Illuminate\Support\Facades\View;
use Symfony\Component\Console\Helper\Helper;

final class Menu
{

    public static $users = [
        Acl::PERMISSION_ENV_USERS,
        Acl::PERMISSION_ENV_ROLES
    ];

    /*
     * @param $route
     * @param $permission
     * @param $icon
     * @param $label
     * @param $active
     * @return mixed
     */
    public static function generateItem($route, $permission, $label, $active, $icon = 'lens'){

        return \App\Helpers\Helper::permissionTo($permission) ? View::make('menus.common.item', [
            'route'=>$route,
            'permission'=>$permission,
            'icon'=>$icon,
            'label'=>$label,
            'active'=>$active
        ])->render() : "";
    }
}
