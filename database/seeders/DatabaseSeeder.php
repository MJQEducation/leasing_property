<?php

namespace Database\Seeders;

use App\Models\Mainvaluelist;
use App\Models\Role;
use App\Models\User;
use App\Models\UserCampus;
use App\Models\UserDepartment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */

    private function addMVL()
    {
        $jsonString = file_get_contents(base_path('/database/seeders/mvl.json'));
        $mvls = json_decode($jsonString, true)['RECORDS'];

        foreach ($mvls as $mvl) {
            $m = new Mainvaluelist();
            $m->id = $mvl['id'];
            $m->abbreviation = $mvl['abbreviation'];
            $m->name_en = $mvl['name_en'];
            $m->name_kh = $mvl['name_kh'];
            $m->type = $mvl['type'];
            $m->value = $mvl['value'];
            $m->ordinal = $mvl['ordinal'];
            $m->parent_mvl = $mvl['parent_mvl'];
            $m->maker = $mvl['maker'];
            $m->delby = $mvl['delby'];
            $m->save();
        }

        DB::select("SELECT setval('mainvaluelists_id_seq', (SELECT MAX(id) from mainvaluelists))");
    }

    private function addUserCampus()
    {
        $jsonString = file_get_contents(base_path('/database/seeders/user_campuses.json'));
        $assets = json_decode($jsonString, true)['RECORDS'];

        foreach ($assets as $asset) {
            $uc = new UserCampus();
            $uc->id = $asset['id'];
            $uc->user_id = $asset['UserId'];
            $uc->campus = 14;
            $uc->save();
        }

        DB::select("SELECT setval('user_campuses_id_seq', (SELECT MAX(id) from user_campuses))");
    }

    private function addUserDepartment()
    {
        $jsonString = file_get_contents(base_path('/database/seeders/user_department.json'));
        $assets = json_decode($jsonString, true)['RECORDS'];

        foreach ($assets as $asset) {
            $uc = new UserDepartment();
            $uc->id = $asset['id'];
            $uc->user_id = $asset['user_id'];
            $uc->department = $asset['department'];
            $uc->is_default = $asset['is_default'];
            $uc->save();
        }

        DB::select("SELECT setval('user_campuses_id_seq', (SELECT MAX(id) from user_campuses))");
    }

    private function addUser()
    {
        $jsonString = file_get_contents(base_path('/database/seeders/users.json'));
        $users = json_decode($jsonString, true)['RECORDS'];

        foreach ($users as $user) {
            $u = new User();
            $u->id = $user['id'];
            $u->card_id = $user['CardId'];
            $u->name = $user['name'];
            $u->position = $user['position'];
            $u->username = $user['username'];
            $u->email = str::lower($user['email']);
            $u->google_id = $user['google_id'];
            $u->email_verified_at = $user['email_verified_at'];
            $u->password = $user['password'];
            $u->maker = $user['maker'];
            $u->delby = $user['delby'];
            $u->save();
        }

        $user = User::find(1770);
        $user->roles()->attach(1);

        DB::select("SELECT setval('users_id_seq', (SELECT MAX(id) from users))");
    }

    public function run()
    {
        $user = new User();
        $user->card_id = null;
        $user->name = 'Administrator';
        $user->email = null;
        $user->username = 'admin';
        $user->password = bcrypt('Abc@123');
        $user->maker = 1;
        $user->save();

        $role = new Role();
        $role->name = 'Admin';
        $role->is_admin = true;
        $role->description = 'System Administrator';
        $role->save();

        $role1 = new Role();
        $role1->name = 'Default';
        $role1->is_admin = false;
        $role1->description = 'Limited Action';
        $role1->save();

        $user->roles()->attach($role->id);

        $ds = new DatabaseSeeder();
        $ds->addMVL();
        $ds->addUser();
        $ds->addUserCampus();
        $ds->addUserDepartment();
    }
}
