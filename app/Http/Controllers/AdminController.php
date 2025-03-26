<?php
namespace App\Http\Controllers;

use App\Helper\RBAC;
use App\Models\Mainvaluelist;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use DateTimeZone;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    #region User
    public function viewUser()
    {
        if (session()->has('AuthToken') == false) {
            return redirect('login');
        }

        if (! RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            //return redirect to authourized
            return View('social.unauthorized');
        }

        return View('Admin.user');
    }

    public function saveUserImage(Request $request)
    {
        if (! RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            //return redirect to authourized
            return ['result' => 'error', 'msg' => 'Unauthorized Action', 'data' => ''];
        }

        $image_64  = $request->base64img; //your base64 encoded data
        $extension = explode(
            '/',
            explode(':', substr($image_64, 0, strpos($image_64, ';')))[1]
        )[1]; // .jpg .png .pdf

        $image     = str_replace('data:image/jpeg;base64,', '', $image_64);
        $image     = str_replace('data:image/png;base64,', '', $image);
        $image     = str_replace(' ', '+', $image);
        $imageName = $request->userid . '.jpg';
        Storage::disk('local')->put('/public/files/userimg/' . $imageName, base64_decode($image));

        $imagecompress = str_replace('data:image/jpeg;base64,', '', $request->compressbase64);
        $imagecompress = str_replace('data:image/png;base64,', '', $imagecompress);
        $imagecompress = str_replace(' ', '+', $imagecompress);
        $imageName     = $request->userid . 'compress.jpg';
        Storage::disk('local')->put('/public/files/userimg/' . $imageName, base64_decode($imagecompress));

        return [
            'result' => 'success',
            'msg'    => 'File save success',
            'data'   => '',
        ];
    }

    public function viewUserPhoto(Request $request)
    {
        if (! RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            //return redirect to authourized
            return ['result' => 'error', 'msg' => 'Unauthorized Action', 'data' => ''];
        }

        $userid   = $request->userid;
        $user     = User::find($userid);
        $username = $user->username;

        if (Storage::disk('local')->exists('/public/files/userimg/' . $userid . '.jpg')) {
            $imagebase64 = 'data:image/jpeg;base64,' . base64_encode(Storage::disk('local')->get('/public/files/userimg/' . $userid . '.jpg'));

            return View('Admin.viewUserPhoto')
                ->with('filepath', $userid . '.jpg')
                ->with('imagebase64', $imagebase64)
                ->with('username', $username);
        } else {
            return ['result' => 'error', 'msg' => 'User photo not found', 'data' => ""];
        }
    }

    public function getUsers(Request $request)
    {
        if (! RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            //return redirect to authourized
            return ['result' => 'error', 'msg' => 'Unauthorized Action', 'data' => ''];
        }

        $start       = $request->start;
        $length      = $request->length;
        $searchValue = $request->search['value'] == null ? "" : $request->search['value'];
        $orderColumn = $request->columns[$request->order[0]['column']]['name']; //Name of order column
        $AscDesc     = $request->order[0]['dir'];                               //asc or desc

        $recordsTotal    = 0;
        $recordsFiltered = 0;

        $users = [];

        if ($searchValue != "") {
            $sql      = '';
            $sqlcount = '';

            $sql = 'SELECT
            u.id,
            u.card_id,
            u.name,
            u.username,
            u.position,
            u.email
            FROM users u
            WHERE deleted_at IS NULL AND
            (
                u.name LIKE ?
                OR u.username LIKE ?
                OR email LIKE ?
                OR u.card_id LIKE ?
                OR u."position" LIKE ?
            )
            ORDER BY u."' . $orderColumn . '" ' . $AscDesc;

            $sqlcount = 'SELECT COUNT(u.id) AS "TotalData" FROM users u WHERE deleted_at IS NULL';

            $users = DB::select($sql, [
                '%' . $searchValue . '%',
                '%' . $searchValue . '%',
                '%' . $searchValue . '%',
                '%' . $searchValue . '%',
                $searchValue,
            ]);
            $totalSQL = DB::select($sqlcount);

            $recordsTotal    = $totalSQL[0]->TotalData;
            $recordsFiltered = count($users);

            $users = array_splice($users, $start, $length);
        } else {
            $sql      = '';
            $sqlcount = '';

            $sql = 'SELECT
            u.id,
            u.card_id,
            u.name,
            u.username,
            u.position,
            u.email
            FROM users u WHERE deleted_at IS NULL
            ORDER BY u."' . $orderColumn . '" ' . $AscDesc;

            $sqlcount = 'SELECT COUNT(u.id) AS "TotalData" FROM users u WHERE deleted_at IS NULL';

            $users    = DB::select($sql);
            $totalSQL = DB::select($sqlcount);

            $recordsTotal    = $totalSQL[0]->TotalData;
            $recordsFiltered = count($users);

            $users = array_splice($users, $start, $length);
        }

        $userobject = [];
        $photo      = "";
        $i          = $start;

        foreach ($users as $user) {

            $i = $i + 1;

            if (Storage::disk('local')->exists('/public/files/userimg/' . $user->id . 'compress.jpg')) {
                $photo = base64_encode(Storage::disk('local')->get('/public/files/userimg/' . $user->id . 'compress.jpg'));
            } else {
                //$photo = base64_encode(file_get_contents('files/userimg/nophoto.jpg'));
                $photo = "";
            }

            $userobject[] = ["no" => $i, "id" => $user->id, "card_id" => $user->card_id, "name" => $user->name, "username" => $user->username, "position" => $user->position, "email" => $user->email, "photo" => $photo];
        }

        return ['data' => $userobject, 'draw' => $request->draw, 'recordsTotal' => $recordsTotal, 'recordsFiltered' => $recordsFiltered];
    }

    public function getUserRole(Request $request)
    {
        if (! RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            //return redirect to authourized
            return ['result' => 'error', 'msg' => 'Unauthorized Action', 'data' => ''];
        }

        $role = DB::select(
            'SELECT DISTINCT r.*,? userid,CASE WHEN ru.user_id IS NULL THEN 0 ELSE 1 END AS permit FROM
        roles r LEFT OUTER JOIN role_user ru ON r.id=RU.role_id AND ru.user_id=?',
            [$request->userid, $request->userid]
        );

        return ['result' => 'success', 'msg' => '', 'data' => $role];
    }

    public function assignRole(Request $request)
    {
        if (! RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            //return redirect to authourized
            return ['result' => 'error', 'msg' => 'Unauthorized Action', 'data' => ''];
        }

        $userid  = $request->userid;
        $roleid  = $request->roleid;
        $checked = $request->checked;
        $user    = User::find($userid);
        $role    = Role::find($roleid);

        if ($checked == 'true') {
            //$data = 'add';
            $findrole = DB::select(
                'SELECT * FROM role_user WHERE user_id=? AND role_id=?',
                [$userid, $roleid]
            );

            if (! $findrole) {
                // DB::insert(
                //     'INSERT INTO `role_user`(`role_id`, `user_id`,`maker`, `created_at`, `updated_at`) VALUES (?,?,?,?,?)',
                //     [$roleid, $userid, session('userid'), Carbon::now(), Carbon::now()]
                // );
                $newRoleUser          = new RoleUser();
                $newRoleUser->role_id = $roleid;
                $newRoleUser->user_id = $userid;
                $newRoleUser->maker   = session('userid');
                $newRoleUser->save();
            }

            return [
                'result' => 'success',
                'msg'    => $role->name . ' have been assign to ' . $user->name,
                'data'   => '',
            ];
        } else {
            // DB::delete('DELETE FROM role_user WHERE user_id=? AND role_id=?', [
            //     $userid,
            //     $roleid,
            // ]);

            DB::update('update role_user set delby=? where user_id=? and role_id=?', [session('userid'), $userid, $roleid]);

            $roleUser = RoleUser::where('user_id', $userid)->where('role_id', $roleid)->first();
            $roleUser->delete();
            return [
                'result' => 'warning',
                'msg'    => $role->name . ' have been remove from ' . $user->name,
                'data'   => '',
            ];
        }
    }

    public function editUser(Request $request)
    {
        if (! RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            //return redirect to authourized
            return ['result' => 'error', 'msg' => 'Unauthorized Action', 'data' => ''];
        }

        $user = User::find($request->id);

        return ['result' => 'success', 'msg' => '', 'data' => $user];
    }

    public function updateUser(Request $request)
    {
        if (! RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            //return redirect to authourized
            return ['result' => 'error', 'msg' => 'Unauthorized Action', 'data' => ''];
        }
        $request->validate(['name' => 'required', 'username' => 'required']);

        try {
            $user           = User::find($request->id);
            $user->name     = $request->name;
            $user->position = $request->position;
            $user->card_id  = $request->card_id;
            $user->username = $request->username;
            $user->email    = str::lower($request->email);
            $user->maker    = session('userid');
            $user->save();
        } catch (QueryException $e) {
            return [
                'result' => 'error',
                'msg'    => 'Error while save user',
                'data'   => $e,
            ];
        }

        if (Storage::disk('local')->exists('/public/files/userimg/' . $user->id . 'compress.jpg')) {
            $photo = base64_encode(Storage::disk('local')->get('/public/files/userimg/' . $user->id . 'compress.jpg'));
        } else {
            //$photo = base64_encode(file_get_contents('files/userimg/nophoto.jpg'));
            $photo = "";
        }
        $userobject = ["no" => 0, "id" => $user->id, "name" => $user->name, "position" => $user->position, "card_id" => $user->card_id, "username" => $user->username, "email" => $user->email, "photo" => $photo];

        return [
            'result' => 'success',
            'msg'    => 'User : ' . $user->username . ' have been update',
            'data'   => $userobject,
        ];
    }

    public function resetPassword(Request $request)
    {
        if (! RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            //return redirect to authourized
            return ['result' => 'error', 'msg' => 'Unauthorized Action', 'data' => ''];
        }

        $user           = User::find($request->id);
        $user->password = bcrypt($request->password);
        $user->maker    = session('userid');
        $user->save();

        $userobject = ["no" => 0, "id" => $user->id, "name" => $user->name, "card_id" => $user->card_id, "username" => $user->username, "email" => $user->email, "photo" => null];

        return [
            'result' => 'success',
            'msg'    => 'User : ' . $user->username . ' have been change password',
            'data'   => $userobject,
        ];
    }

    public function saveUser(Request $request)
    {
        if (! RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            //return redirect to authourized
            return ['result' => 'error', 'msg' => 'Unauthorized Action', 'data' => ''];
        }

        try {
            $request->validate(['name' => 'required', 'username' => 'required']);

            $user           = new User();
            $user->card_id  = $request->card_id;
            $user->name     = $request->name;
            $user->position = $request->position;
            $user->username = $request->username;
            $user->email    = str::lower($request->email);
            $user->password = bcrypt('hxe7nAk6E2d9QkP');
            $user->maker    = session('userid');
            $user->save();

            $userobject = ["no" => 0, "id" => $user->id, "name" => $user->name, "card_id" => $user->card_id, "position" => $user->position, "username" => $user->username, "email" => $user->email, "photo" => null];

            return [
                'result' => 'success',
                'msg'    => 'User : ' . $user->username . ' have been save',
                'data'   => $userobject,
            ];
        } catch (QueryException $e) {
            return [
                'result' => 'error',
                'msg'    => 'Error while save user',
                'data'   => $e,
            ];
        }
    }

    public function deleteUser(Request $request)
    {
        if (! RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            //return redirect to authourized
            return ['result' => 'error', 'msg' => 'Unauthorized Action', 'data' => ''];
        }

        $user        = User::find($request->id);
        $user->delby = session('userid');
        $user->save();
        $user->delete();

        return [
            'result' => 'success',
            'msg'    => 'User : ' . $user->username . ' have been save',
            'data'   => $user,
        ];
    }

    #endregion

    #region Permission
    public function viewPermission()
    {
        if (session()->has('AuthToken') == false) {
            return redirect('login');
        }

        if (! RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            //return redirect to authourized
            return View('social.unauthorized');
        }

        return View('Admin.permission');
    }

    public function getpermissionlist()
    {
        if (! RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            //return redirect to authourized
            return ['result' => 'error', 'msg' => 'Unauthorized Action', 'data' => ''];
        }

        $permissions = RBAC::getPermissionName(); // In Controller

        foreach ($permissions as $permissionarray) {
            if (array_key_exists('controller', $permissionarray)) {
                $route = $permissionarray['controller'];

                if (Str::contains($route, 'App\\Http\\Controllers\\')) {
                    $routefragment = explode('@', $route);
                    $permission    = Str::replace('Controller', '', Str::replace('App\\Http\\Controllers\\', '', $routefragment[0])) . '-' . $routefragment[1];
                    $p             = null;
                    $p             = Permission::where('name', $permission)->first();

                    if ($p == null) {
                        $newP           = new Permission();
                        $newP->name     = $permission;
                        $newP->module   = Str::replace('App\\Http\\Controllers\\', '', $routefragment[0]);
                        $newP->remark   = '';
                        $newP->is_exist = true;
                        $newP->save();
                    }
                }
            }
        }

        $apppermission = Permission::all();

        return ['result' => 'success', 'msg' => '', 'data' => $apppermission];
    }

    #endregion

    #region role
    public function viewroles()
    {
        if (session()->has('AuthToken') == false) {
            return redirect('login');
        }

        if (! RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            //return redirect to authourized
            return View('social.unauthorized');
        }

        return View('Admin.roles');
    }

    public function getrolelist()
    {
        if (! RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            //return redirect to authourized
            return ['result' => 'error', 'msg' => 'Unauthorized Action', 'data' => ''];
        }

        $roles = Role::all();
        return ['result' => 'success', 'msg' => '', 'data' => $roles];
    }

    public function saverole(Request $request)
    {
        if (! RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            //return redirect to authourized
            return ['result' => 'error', 'msg' => 'Unauthorized Action', 'data' => ''];
        }

        $request->validate(['name' => 'required', 'description' => 'required']);

        $role              = new Role();
        $role->name        = $request->name;
        $role->is_admin    = $request->is_admin == 'true' ? true : false;
        $role->maker       = session('userid');
        $role->description = $request->description;
        $role->save();

        return [
            'result' => 'success',
            'msg'    => 'Role : ' . $role->name . ' have been save',
            'data'   => $role,
        ];
    }

    public function editrole(Request $request)
    {
        if (! RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            //return redirect to authourized
            return ['result' => 'error', 'msg' => 'Unauthorized Action', 'data' => ''];
        }

        $role = Role::find($request->id);

        return [
            'result' => 'success',
            'msg'    => 'Role : ' . $role->name . ' have been save',
            'data'   => $role,
        ];
    }

    public function updaterole(Request $request)
    {
        if (! RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            //return redirect to authourized
            return ['result' => 'error', 'msg' => 'Unauthorized Action', 'data' => ''];
        }

        $role              = Role::find($request->id);
        $role->name        = $request->name;
        $role->is_admin    = $request->is_admin == 'true' ? true : false;
        $role->description = $request->description;
        $role->maker       = session('userid');
        $role->save();

        return [
            'result' => 'success',
            'msg'    => 'Role : ' . $role->name . ' have been update',
            'data'   => $role,
        ];
    }

    public function deleterole(Request $request)
    {
        if (! RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            //return redirect to authourized
            return ['result' => 'error', 'msg' => 'Unauthorized Action', 'data' => ''];
        }

        $role        = Role::find($request->id);
        $rolename    = $role->name;
        $role->delby = session('userid');
        $role->save();
        $role->delete();

        return [
            'result' => 'success',
            'msg'    => 'Role : ' . $rolename . ' have been deleted',
            'data'   => '',
        ];
    }

    public function getrolepermission(Request $request)
    {
        if (! RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            //return redirect to authourized
            return ['result' => 'error', 'msg' => 'Unauthorized Action', 'data' => ''];
        }

        $roleid = $request->roleid;

        $permissions = DB::select(
            'SELECT P.*,? role_id,CASE WHEN RP.role_id IS NULL THEN 0 ELSE 1 END AS permit FROM permissions P LEFT JOIN role_permission RP ON P.id=RP.permission_id AND RP.role_id=?;',
            [$roleid, $roleid]
        );

        return ['result' => 'success', 'msg' => '', 'data' => $permissions];
    }

    public function assignPermission(Request $request)
    {
        if (! RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            //return redirect to authourized
            return ['result' => 'error', 'msg' => 'Unauthorized Action', 'data' => ''];
        }

        $permit       = $request->permit == 'true' ? true : false;
        $permissionid = $request->permissionid;
        $role_id      = $request->role_id;
        $role         = Role::find($role_id);
        $permission   = Permission::find($permissionid);

        $RP = DB::select(
            'SELECT * FROM role_permission WHERE permission_id=? AND role_id=?',
            [$permissionid, $role_id]
        );

        if ($permit == true) {
            if ($RP == null) {
                DB::insert(
                    'INSERT INTO role_permission(role_id, permission_id,maker, created_at, updated_at) VALUES (?,?,?,?,?)',
                    [$role_id, $permissionid, session('userid'), Carbon::now(), Carbon::now()]
                );

                return [
                    'result' => 'success',
                    'msg'    =>
                    'Permission ' .
                    $permission->name .
                    ' have been add to ' .
                    $role->name,
                    'data'   => '',
                ];
            } else {
                return [
                    'result' => 'success',
                    'msg'    =>
                    'Permission ' .
                    $permission->name .
                    ' have been add to ' .
                    $role->name,
                    'data'   => '',
                ];
            }
        } else {
            if ($RP != null) {
                DB::delete(
                    'DELETE FROM role_permission WHERE role_id=? AND permission_id=?',
                    [$role_id, $permissionid]
                );

                return [
                    'result' => 'warning',
                    'msg'    =>
                    'Permission ' .
                    $permission->name .
                    ' have been remove from ' .
                    $role->name,
                    'data'   => '',
                ];
            } else {
                return [
                    'result' => 'warning',
                    'msg'    =>
                    'Permission ' .
                    $permission->name .
                    ' have been remove from ' .
                    $role->name,
                    'data'   => '',
                ];
            }
        }
    }
    #endregion

    #region Campus
    public function getCampus(Request $request)
    {
        if (! RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            //return redirect to authourized
            return ['result' => 'error', 'msg' => 'Unauthorized Action', 'data' => ''];
        }

        try {
            $UserCampus = DB::select("select uc.id,? as user_id,m.abbreviation as campus,m.id as campus_id,
            case  when uc.id is null then 0 else 1 end as is_assign,m.ordinal
            from mainvaluelists m left join user_campuses uc
            on m.id=uc.campus and uc.user_id=?
            where m.\"type\"='Campus'
            order by m.ordinal asc", [$request->userid, $request->userid]);

            return ['result' => 'success', 'msg' => '', 'data' => $UserCampus];
        } catch (Exception $e) {
            return ['result' => 'error', 'msg' => $e->getMessage(), 'data' => $e];
        }
    }

    public function assignCampus(Request $request)
    {
        if (! RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            //return redirect to authourized
            return ['result' => 'error', 'msg' => 'Unauthorized Action', 'data' => ''];
        }
        $user_id   = $request->user_id;
        $campus    = $request->campus;
        $is_assign = $request->is_assign;

        $user = User::find($user_id);
        $date = Carbon::now(new DateTimeZone('Asia/Phnom_Penh'));

        if ($is_assign == 1) {
            $usercampus = DB::select('SELECT * FROM user_campuses WHERE user_id=? AND campus=?', [$user_id, $campus]);

            if ($usercampus == null) {
                DB::insert('INSERT INTO user_campuses(user_id, campus, created_at, updated_at)
                VALUES(?, ?, ?, ?);
                ', [$user_id, $campus, $date, $date]);

                $campusMVL = Mainvaluelist::find($campus);

                return ['result' => 'success', 'msg' => $campusMVL->abbreviation . ' campus have been add to ' . $user->name, 'data' => ""];
            }
        } else {
            $usercampus = DB::select('SELECT * FROM user_campuses WHERE user_id=? AND campus=?', [$user_id, $campus]);
            if ($usercampus != null) {
                DB::delete('DELETE FROM user_campuses
                WHERE user_id=? AND campus=?', [$user_id, $campus]);

                $campusMVL = Mainvaluelist::find($campus);

                return ['result' => 'warning', 'msg' => $campusMVL->abbreviation . ' campus have been remove from ' . $user->name, 'data' => ""];
            }
        }
    }
    #endregion

    #region Department
    public function getDepartment(Request $request)
    {
        if (! RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            //return redirect to authourized
            return ['result' => 'error', 'msg' => 'Unauthorized Action', 'data' => ''];
        }

        try {
            $userDepartment = DB::select("select ud.id,? as user_id,m.abbreviation as department,m.id as department_id,
            case  when ud.id is null then 0 else 1 end as is_assign,m.ordinal
            from mainvaluelists m left join user_departments ud
            on m.id=ud.department and ud.user_id=?
            where m.\"type\"='Department'
            order by m.ordinal asc", [$request->userid, $request->userid]);

            return ['result' => 'success', 'msg' => '', 'data' => $userDepartment];
        } catch (Exception $e) {
            return ['result' => 'error', 'msg' => $e->getMessage(), 'data' => $e];
        }
    }

    public function assignDepartment(Request $request)
    {
        if (! RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            //return redirect to authourized
            return ['result' => 'error', 'msg' => 'Unauthorized Action', 'data' => ''];
        }
        $user_id    = $request->user_id;
        $department = $request->department;
        $is_assign  = $request->is_assign;

        $user = User::find($user_id);
        $date = Carbon::now(new DateTimeZone('Asia/Phnom_Penh'));

        if ($is_assign == 1) {
            $userDepartment = DB::select('SELECT * FROM user_departments WHERE user_id=? AND department=?', [$user_id, $department]);

            if ($userDepartment == null) {
                DB::insert('INSERT INTO user_departments(user_id, department, created_at, updated_at)
                VALUES(?, ?, ?, ?);
                ', [$user_id, $department, $date, $date]);

                $departmentMVL = Mainvaluelist::find($department);

                return ['result' => 'success', 'msg' => $departmentMVL->abbreviation . ' Department have been add to ' . $user->name, 'data' => ""];
            }
        } else {
            $userDepartment = DB::select('SELECT * FROM user_departments WHERE user_id=? AND department=?', [$user_id, $department]);
            if ($userDepartment != null) {
                DB::delete('DELETE FROM user_departments
                WHERE user_id=? AND department=?', [$user_id, $department]);

                $departmentMVL = Mainvaluelist::find($department);

                return ['result' => 'warning', 'msg' => $departmentMVL->abbreviation . ' Department have been remove from ' . $user->name, 'data' => ""];
            }
        }
    }
    #endregion
}
