<?php

namespace App\Models;

use App\Helpers\Menu;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission AS BasePermission;

class Permission extends BasePermission
{

    use HasFactory;

    public static function getEnvPermissions() {

        $data = [];
        $vars = get_class_vars('Menu');
        foreach ($vars as $key => $var) {
            $data[$key] = static::query()
                ->whereIn('env', $var)
                ->orderBy('env')
                ->get()
                ->groupBy('env');
        }

        return $data;

    }

}
