<?php

namespace App\Http\Controllers;

use App\Helper\RBAC;
use App\Models\Mainvaluelist;
use App\Models\User;
use App\Models\UserCampus;
use App\Models\UserDepartment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller
{
    public function index()
    {
        if (session()->has('AuthToken') == false) {
            return redirect('login');
        }

        if (!RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            //return redirect to authourized
            return View('social.unauthorized');
        }

        $data = DB::select('
        SELECT abbreviation, MIN(name_en) as name_en, COUNT(abbreviation) as abbreviation_count
        FROM mainvaluelists
        GROUP BY abbreviation
        ORDER BY abbreviation;
    ');

    $GraphData = DB::select("
        SELECT
            -- Retail LeaseOut and Retail Available for SM, RC, AFC, SS, OSR
            COUNT(CASE WHEN value != '0' AND abbreviation IN ('SM', 'RC', 'AFC', 'SS', 'OSR') THEN abbreviation END) AS \"Retail_LeaseOut\",
            COUNT(CASE WHEN value = '0' AND abbreviation IN ('SM', 'RC', 'AFC', 'SS', 'OSR') THEN abbreviation END) AS \"Retail_Available\",

            -- MJQE PLAZA LeaseOut and Land Available for land
            COUNT(CASE WHEN value != '0' AND abbreviation = 'mjq' THEN abbreviation END) AS \"MJQE_PLAZA_LeaseOut\",
            COUNT(CASE WHEN value = '0' AND abbreviation = 'mjq' THEN abbreviation END) AS \"MJQE_PLAZA_Available\",

            -- Land LeaseOut and Land Available for land
            COUNT(CASE WHEN value != '0' AND abbreviation = 'land' THEN abbreviation END) AS \"Land_LeaseOut\",
            COUNT(CASE WHEN value = '0' AND abbreviation = 'land' THEN abbreviation END) AS \"Land_Available\",

            -- Building LeaseOut and Land Available for land
            COUNT(CASE WHEN value != '0' AND abbreviation = 'bu' THEN abbreviation END) AS \"Building_LeaseOut\",
            COUNT(CASE WHEN value = '0' AND abbreviation = 'bu' THEN abbreviation END) AS \"Building_Available\"
        FROM mainvaluelists;
    ");


        return View('users_profile.index',compact('data','GraphData'));
    }

    public function getMyInfo()
    {
        if (!RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            //return redirect to authourized
            return ['result' => 'error', 'msg' => 'Unauthorized Action', 'data' => ""];
        }

        $user = User::find(session("userid"));

        $campus = DB::select("select m.abbreviation as campus  from user_campuses uc inner join mainvaluelists m
        on uc.campus=m.id where uc.user_id=? and uc.is_default=true", [session('userid')]);

        if ($campus === []) {
            $campus = DB::select("select m.abbreviation as campus  from user_campuses uc inner join mainvaluelists m
            on uc.campus=m.id where uc.user_id=?", [session('userid')]);
        }

        $departmet = DB::select("select m.abbreviation as department from user_departments ud  inner join mainvaluelists m
        on ud.department=m.id where ud.user_id=? and ud.is_default=true", [session('userid')]);

        if ($departmet === []) {
            $departmet = DB::select("select m.abbreviation as department from user_departments ud  inner join mainvaluelists m
            on ud.department=m.id where ud.user_id=?", [session('userid')]);
        }

        $signatureImage = "";
        $userImage = "";

        if (Storage::disk('local')->exists("/public/files/signatureimg/{$user->id}.jpg")) {
            $signatureImage = 'data:image/jpeg;base64,' . base64_encode(Storage::disk('local')->get('/public/files/signatureimg/' . $user->id . '.jpg'));
        } else {
            $signatureImage = 'data:image/png;base64,' . base64_encode(Storage::disk('local')->get('/public/files/signatureimg/noSignature.png'));
        }

        if (Storage::disk('local')->exists("/public/files/userimg/{$user->id}.jpg")) {
            $userImage = 'data:image/jpeg;base64,' . base64_encode(Storage::disk('local')->get('/public/files/userimg/' . $user->id . '.jpg'));
        } else {
            $userImage = 'data:image/jpeg;base64,' . base64_encode(Storage::disk('local')->get('/public/files/userimg/nophoto.jpg'));
        }

        $data = ['user' => $user, 'userPhoto' => $userImage, 'signature' => $signatureImage, 'campus' => $campus === [] ? null : $campus[0]->campus, 'department' => $departmet === [] ? null : $departmet[0]->department];

        return ['result' => 'success', 'msg' => '', 'data' => $data];
    }

    public function getPanelInfo()
    {
        if (!RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            //return redirect to authourized
            return ['result' => 'error', 'msg' => 'Unauthorized Action', 'data' => ""];
        }

    }

    public function getMyAssignCampus()
    {
        if (!RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            //return redirect to authourized
            return ['result' => 'error', 'msg' => 'Unauthorized Action', 'data' => ''];
        }

        $userId = session("userid");
        $usercampus = DB::select("select uc.id,
                            uc.user_id,
                            m.abbreviation as campus,
                            uc.is_default
                    from
                        user_campuses uc inner join mainvaluelists m
                    on uc.campus=m.id
                    where uc.user_id=?", [$userId]);

        return ['result' => 'success', 'msg' => 'Campus data have been return', 'data' => $usercampus];
    }

    public function assignDefualtCampus(Request $request)
    {
        if (!RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            //return redirect to authourized
            return ['result' => 'error', 'msg' => 'Unauthorized Action', 'data' => ''];
        }

        $usercampus = UserCampus::find($request->id);
        $userid = $usercampus->user_id;
        $mvl = Mainvaluelist::find($usercampus->campus);

        DB::update("UPDATE user_campuses SET is_default=NULL WHERE user_id=?", [$userid]);
        $usercampus->is_default = true;
        $usercampus->save();

        return ['result' => 'success', 'msg' => $mvl->abbreviation . " campus have been assign to you", 'data' => null];
    }

    public function getMyAssignDepartment()
    {
        if (!RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            //return redirect to authourized
            return ['result' => 'error', 'msg' => 'Unauthorized Action', 'data' => ''];
        }

        $userid = session("userid");
        $userDepartment = DB::select("select ud.id,
                                        ud.user_id,
                                        m.abbreviation as department,
                                        ud.is_default
                                from
                                    user_departments ud inner join mainvaluelists m
                                on ud.department=m.id
                                where ud.user_id=?", [$userid]);

        return ['result' => 'success', 'msg' => 'department data have been return', 'data' => $userDepartment];
    }

    public function assignDefualtDepartment(Request $request)
    {
        if (!RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            //return redirect to authourized
            return ['result' => 'error', 'msg' => 'Unauthorized Action', 'data' => ''];
        }

        $userDepartment = UserDepartment::find($request->id);
        $userid = $userDepartment->user_id;

        DB::update("UPDATE user_departments SET is_default=NULL WHERE user_id=?", [$userid]);
        $userDepartment->is_default = true;
        $userDepartment->save();

        $department = Mainvaluelist::find($userDepartment->department);

        return ['result' => 'success', 'msg' => $department->abbreviation . " have been assign to you", 'data' => $userDepartment];
    }

    public function saveSignatureImage(Request $request)
    {
        if (!RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            //return redirect to authourized
            return ['result' => 'error', 'msg' => 'Unauthorized Action', 'data' => ''];
        }

        $image_64 = $request->base64img; //your base64 encoded data
        $extension = explode(
            '/',
            explode(':', substr($image_64, 0, strpos($image_64, ';')))[1]
        )[1]; // .jpg .png .pdf

        $image = str_replace('data:image/jpeg;base64,', '', $image_64);
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = $request->userId . '.jpg';
        Storage::disk('local')->put('/public/files/signatureimg/' . $imageName, base64_decode($image));

        $imagecompress = str_replace('data:image/jpeg;base64,', '', $request->compressbase64);
        $imagecompress = str_replace('data:image/png;base64,', '', $imagecompress);
        $imagecompress = str_replace(' ', '+', $imagecompress);
        $imageName = $request->userId . 'compress.jpg';
        Storage::disk('local')->put('/public/files/signatureimg/' . $imageName, base64_decode($imagecompress));

        return [
            'result' => 'success',
            'msg' => 'File save success',
            'data' => '',
        ];
    }

    public function saveUserImage(Request $request)
    {
        if (!RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            //return redirect to authourized
            return ['result' => 'error', 'msg' => 'Unauthorized Action', 'data' => ''];
        }

        $image_64 = $request->base64img; //your base64 encoded data
        $extension = explode(
            '/',
            explode(':', substr($image_64, 0, strpos($image_64, ';')))[1]
        )[1]; // .jpg .png .pdf

        $user = User::find($request->userId);

        try {
            $image = str_replace('data:image/jpeg;base64,', '', $image_64);
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = $user->id . '.jpg';
            Storage::disk('local')->put('/public/files/userimg/' . $imageName, base64_decode($image));

            $imagecompress = str_replace('data:image/jpeg;base64,', '', $request->compressbase64);
            $imagecompress = str_replace('data:image/png;base64,', '', $imagecompress);
            $imagecompress = str_replace(' ', '+', $imagecompress);
            $imageName = $user->id . 'compress.jpg';
            Storage::disk('local')->put('/public/files/userimg/' . $imageName, base64_decode($imagecompress));
        } catch (Exception $e) {
            return [
                'result' => 'Error',
                'msg' => $e->getMessage(),
                'data' => $e,
            ];
        }

        return [
            'result' => 'success',
            'msg' => 'File save success',
            'data' => '',
        ];
    }
}
