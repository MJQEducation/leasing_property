<?php

namespace App\Helper;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\PersonalAccessToken;

class RBAC
{
    public static function isAccessible($permision)
    {
        $userid = PersonalAccessToken::findToken(session('AuthToken'))->tokenable->id;

        $isAdmin = DB::select('SELECT r.* FROM users u INNER JOIN role_user ru
        ON u.id=ru.user_id
        INNER JOIN roles r ON r.id=ru.role_id
        WHERE u.id=? AND r.is_admin;', [$userid]);

        if (!$isAdmin == null) {
            return true;
        }

        $data = DB::select('SELECT p.* FROM users u INNER JOIN role_user ru ON u.id=ru.user_id
        INNER JOIN roles r ON r.id=ru.role_id
        INNER JOIN role_permission rp ON r.id=rp.role_id
        INNER JOIN permissions p ON p.id=rp.permission_id
        WHERE u.id=? AND p.name=?;', [$userid, $permision]);

        if ($data == null) {
            return false;
        } else {
            return true;
        }
    }

    public static function isAccessibleAPI($permision, $AuthToken)
    {
        $userid = PersonalAccessToken::findToken($AuthToken)->tokenable->id;

        $isAdmin = DB::select('SELECT r.* FROM users u INNER JOIN role_user ru
        ON u.id=ru.user_id
        INNER JOIN roles r ON r.id=ru.role_id
        WHERE u.id=? AND r.is_admin;', [$userid]);

        if (!$isAdmin == null) {
            return true;
        }

        $data = DB::select('SELECT p.* FROM users u INNER JOIN role_user ru ON u.id=ru.user_id
        INNER JOIN roles r ON r.id=ru.role_id
        INNER JOIN role_permission rp ON r.id=rp.role_id
        INNER JOIN permissions p ON p.id=rp.permission_id
        WHERE u.id=? AND p.name=?;', [$userid, $permision]);

        if ($data == null) {
            return false;
        } else {
            return true;
        }
    }

    public static function getPermissionName()
    {
        $permissions = array();
        $routeCollection = Route::getRoutes();
        foreach ($routeCollection as $value) {
            array_push($permissions, $value->action);
        }
        return $permissions;
    }
}
