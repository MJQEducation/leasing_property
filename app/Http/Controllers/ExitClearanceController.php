<?php

namespace App\Http\Controllers;

use App\Helper\ExitClearanceHelper;
use App\Helper\RBAC;
use App\Jobs\Jobs;
use App\Models\ExitClearance;
use App\Models\ExitClearanceBulletin;
use App\Models\ExitClearanceCheckList;
use App\Models\ExitClearanceSignature;
use App\Models\User;
use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

class ExitClearanceController extends Controller
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

        $noPhoto = base64_encode(file_get_contents('files/userimg/nophoto.jpg'));

        $departments = DB::select("select abbreviation from mainvaluelists m  where \"type\" in ('department','Campus')");

        return View('exit_clearance.index')
            ->with('noPhoto', $noPhoto)
            ->with('departments', $departments);
    }

    public function getExitClearanceList(Request $request)
    {
        if (!RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            //return redirect to authourized
            return ['result' => 'error', 'msg' => 'Unauthorized Action', 'data' => ''];
        }

        $start = $request->start;
        $length = $request->length;
        $searchValue = $request->search['value'] == null ? "" : $request->search['value'];
        $orderColumn = $request->columns[$request->order[0]['column']]['name']; //Name of order column
        $AscDesc = $request->order[0]['dir']; //asc or desc

        $recordsTotal = 0;
        $recordsFiltered = 0;

        $disposal = [];

        $userid = session("userid");

        $disposal = DB::select("select
                                re_id id,
                                re_card_id card_id,
                                re_name \"name\",
                                re_position \"position\",
                                re_department department,
                                re_line_management line_management,
                                re_email email,
                                re_phone phone,
                                re_hired_date hired_date,
                                re_last_working_date last_working_date,
                                re_status status,
                                total_record,
                                filter_record
                            from get_exit_clearance_list(?,?,?,?,?,?);", [$searchValue, $orderColumn, $AscDesc, $start, $length, $userid]);

        if (count($disposal) !== 0) {
            $recordsTotal = $disposal[0]->total_record;
            $recordsFiltered = $disposal[0]->filter_record;
        }

        return ['data' => $disposal, 'draw' => $request->draw, 'recordsTotal' => $recordsTotal, 'recordsFiltered' => $recordsFiltered];
    }

    public function getExitClearanceAllList(Request $request)
    {
        if (!RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            //return redirect to authourized
            return ['result' => 'error', 'msg' => 'Unauthorized Action', 'data' => ''];
        }

        $start = $request->start;
        $length = $request->length;
        $searchValue = $request->search['value'] == null ? "" : $request->search['value'];
        $orderColumn = $request->columns[$request->order[0]['column']]['name']; //Name of order column
        $AscDesc = $request->order[0]['dir']; //asc or desc

        $recordsTotal = 0;
        $recordsFiltered = 0;

        $exit = [];

        $exit = DB::select("select
                                re_id id,
                                re_card_id card_id,
                                re_name \"name\",
                                re_position \"position\",
                                re_department department,
                                re_line_management line_management,
                                re_email email,
                                re_phone phone,
                                re_hired_date hired_date,
                                re_last_working_date last_working_date,
                                re_status status,
                                total_record,
                                filter_record
                            from get_exit_clearance_list(?,?,?,?,?);", [$searchValue, $orderColumn, $AscDesc, $start, $length]);

        if (count($exit) !== 0) {
            $recordsTotal = $exit[0]->total_record;
            $recordsFiltered = $exit[0]->filter_record;
        }

        return ['data' => $exit, 'draw' => $request->draw, 'recordsTotal' => $recordsTotal, 'recordsFiltered' => $recordsFiltered];
    }

    public function getExitClearanceRelateList(Request $request)
    {
        if (!RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            //return redirect to authourized
            return ['result' => 'error', 'msg' => 'Unauthorized Action', 'data' => ''];
        }

        $start = $request->start;
        $length = $request->length;
        $searchValue = $request->search['value'] == null ? "" : $request->search['value'];
        $orderColumn = $request->columns[$request->order[0]['column']]['name']; //Name of order column
        $AscDesc = $request->order[0]['dir']; //asc or desc

        $recordsTotal = 0;
        $recordsFiltered = 0;

        $disposal = [];

        $userid = session("userid");

        //     $sql = "select
        //     re_id id,
        //     re_card_id card_id,
        //     re_name \"name\",
        //     re_position \"position\",
        //     re_department department,
        //     re_line_management line_management,
        //     re_email email,
        //     re_phone phone,
        //     re_hired_date hired_date,
        //     re_last_working_date last_working_date,
        //     re_status status,
        //     total_record,
        //     filter_record
        // from get_exit_clearance_relate_list('$searchValue','$orderColumn','$AscDesc',$start, $length, $userid);";

        $disposal = DB::select("select
                            re_id id,
                            re_card_id card_id,
                            re_name \"name\",
                            re_position \"position\",
                            re_department department,
                            re_line_management line_management,
                            re_email email,
                            re_phone phone,
                            re_hired_date hired_date,
                            re_last_working_date last_working_date,
                            re_status status,
                            total_record,
                            filter_record
                        from get_exit_clearance_relate_list(?,?,?,?,?,?);", [$searchValue, $orderColumn, $AscDesc, $start, $length, $userid]);

        if (count($disposal) !== 0) {
            $recordsTotal = $disposal[0]->total_record;
            $recordsFiltered = $disposal[0]->filter_record;
        }

        return ['data' => $disposal, 'draw' => $request->draw, 'recordsTotal' => $recordsTotal, 'recordsFiltered' => $recordsFiltered];
    }

    public function getExitClearanceCheckList()
    {
        if (!RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            //return redirect to authourized
            return ['result' => 'error', 'msg' => 'Unauthorized Action', 'data' => ''];
        }

        $Bulletins = DB::select("SELECT
                        0 id,
                        id mvl_id,
                        abbreviation,
                        name_en,
                        name_kh,
                        \"type\",
                        value,
                        ordinal,
                        parent_mvl
                    FROM mainvaluelists
                    where deleted_at is null and \"type\"='Bulletin'
                    order by ordinal asc");

        $data = [];

        foreach ($Bulletins as $Bulletin) {
            $checkList = DB::select("SELECT
                                        0 id,
                                        id mvl_id,
                                        abbreviation,
                                        name_en,
                                        name_kh,
                                        \"type\",
                                        value,
                                        ordinal,
                                        parent_mvl
                                    FROM mainvaluelists
                                    where deleted_at is null and \"type\"='Check List'
                                    and parent_mvl=?
                                    order by ordinal asc", [$Bulletin->mvl_id]);
            $data[] = ['Bulleting' => $Bulletin, 'CheckList' => $checkList];
        }

        return ['result' => 'success', 'msg' => '', 'data' => $data];
    }

    public function saveExitClearance(Request $request)
    {
        if (!RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            //return redirect to authourized
            return ['result' => 'error', 'msg' => 'Unauthorized Action', 'data' => ''];
        }

        $date = Carbon::now(new DateTimeZone('Asia/Phnom_Penh'));

        $exist_exit = ExitClearance::where('card_id', $request->card_id)->get();

        if (count($exist_exit) > 0) {
            return ['result' => 'error', 'msg' => "Card ID $request->card_id already been register for exit", 'data' => 0];
        }

        $exit_user = User::where('card_id', '$request->card_id')->get();

        if ($exit_user == null) {
            return ['result' => 'error', 'msg' => "System doesn't recognize Card ID = $request->card_id as user in the system", 'data' => 0];
        }

        //Create Exit Clearance Employee
        $exitClearace = new ExitClearance();
        $exitClearace->card_id = $request->card_id;
        $exitClearace->emp_id = $request->emp_id;
        $exitClearace->name = $request->name;
        $exitClearace->position = $request->position;
        $exitClearace->department = $request->department;
        $exitClearace->line_management = $request->line_management;
        $exitClearace->email = $request->email;
        $exitClearace->phone = $request->phone;
        $exitClearace->hired_date = Carbon::createFromFormat('M d, Y', $request->hired_date);
        $exitClearace->last_working_date = Carbon::createFromFormat('M d, Y', $request->last_working_date);
        $exitClearace->status = "Request";
        $exitClearace->maker = session('userid');
        $exitClearace->save();

        $bulletins = $request->bulletins;

        for ($i = 0; $i < count($bulletins); $i++) {
            $bulletin = new ExitClearanceBulletin();
            $bulletin->exit_id = $exitClearace->id;
            $bulletin->questionnaire = $bulletins[$i]['questionnaire'];
            $bulletin->checked_id = $bulletins[$i]['checked_id'];
            $checker = User::find($bulletins[$i]['checked_id']);
            $bulletin->checked_code = $checker->card_id;
            $bulletin->emp_name = $checker->name;
            $bulletin->position = $checker->position;
            $bulletin->ordinal = $bulletins[$i]['ordinal'];
            $bulletin->maker = session('userid');
            $bulletin->save();

            $bulletin_id = $bulletin->id;
            $checklists = $bulletins[$i]['checklist'];

            for ($j = 0; $j < count($checklists); $j++) {
                $checklist = new ExitClearanceCheckList();
                $checklist->bulletin_id = $bulletin_id;
                $checklist->questionnaire = $checklists[$j]['questionnaire'];
                $checklist->is_checked = "Unchecked";
                $checklist->checked_id = $checklists[$j]['checked_id'];
                $checker = User::find($checklists[$j]['checked_id']);
                $checklist->checked_code = $checker->card_id;
                $checklist->emp_name = $checker->name;
                $checklist->position = $checker->position;
                $checklist->ordinal = $checklists[$j]['ordinal'];
                $checklist->maker = session('userid');
                $checklist->save();
            }
        }

        $signatures = $request->signatures;
        for ($i = 0; $i < count($signatures); $i++) {
            $signature = new ExitClearanceSignature();
            $signature->exit_id = $exitClearace->id;
            $signature->sign_title = $signatures[$i]["sign_title"];
            $signature->signed_id = $signatures[$i]["signed_id"];
            $approver = User::find($signatures[$i]["signed_id"]);
            $signature->signed_code = $approver->card_id;
            $signature->emp_name = $approver->name;
            $signature->position = $approver->position;
            if ($signatures[$i]["sign_title"] === "Personnel Officer") {
                //Personnel officer are the one who prepare
                $signature->is_signed = true;
                $signature->signed_date = $date;
            } else {
                $signature->is_signed = false;
            }

            $signature->ordinal = $signatures[$i]['ordinal'];
            $signature->maker = session('userid');
            $signature->save();
        }

        // Add sending Email to Queue Job
        $emails = DB::select("select * from get_notification_email(?)", [$exitClearace->id]);
        foreach ($emails as $email) {
            dispatch(new Jobs($email)); // send object to Jobs
        }

        return ['result' => 'success', 'msg' => $exitClearace->name . ' Lease Management have been save', 'data' => $exitClearace->id];
    }

    public function updateExitClearance(Request $request)
    {
        if (!RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            //return redirect to authourized
            return ['result' => 'error', 'msg' => 'Unauthorized Action', 'data' => ''];
        }
        $today = Carbon::now(new DateTimeZone('Asia/Phnom_Penh'));

        //return ['result' => 'success', 'msg' => "" . ' Lease Management have been update', 'data' => $request->bulletins];

        $exitClearace = ExitClearance::find($request->id);
        $exitClearace->card_id = $request->card_id;
        $exitClearace->emp_id = $request->emp_id;
        $exitClearace->name = $request->name;
        $exitClearace->position = $request->position;
        $exitClearace->department = $request->department;
        $exitClearace->line_management = $request->line_management;
        $exitClearace->email = $request->email;
        $exitClearace->phone = $request->phone;
        $exitClearace->hired_date = Carbon::createFromFormat('M d, Y', $request->hired_date);
        $exitClearace->last_working_date = Carbon::createFromFormat('M d, Y', $request->last_working_date);
        $exitClearace->status = "Request";
        $exitClearace->maker = session('userid');
        $exitClearace->save();

        $bulletins = $request->bulletins;

        DB::update("update exit_clearance_bulletins set deleted_at=? where exit_id=?", [$today, $exitClearace->id]);

        for ($i = 0; $i < count($bulletins); $i++) {
            $checker = User::find($bulletins[$i]['checked_id']);
            DB::update("UPDATE public.exit_clearance_bulletins
            SET
                exit_id=?,
                questionnaire=?,
                checked_id=?,
                checked_code=?,
                emp_name=?,
                \"position\"=?,
                ordinal=?,
                is_completed=false,
                maker=?,
                deleted_at=null
            WHERE questionnaire=? and exit_id=?;", [
                $exitClearace->id,
                $bulletins[$i]['questionnaire'],
                $bulletins[$i]['checked_id'],
                $checker->card_id,
                $checker->name,
                $checker->position,
                $bulletins[$i]['ordinal'],
                session('userid'),
                $bulletins[$i]['questionnaire'],
                $exitClearace->id,
            ]);

            $bulletin = ExitClearanceBulletin::where('exit_id', $exitClearace->id)->where('questionnaire', $bulletins[$i]['questionnaire'])->first();
            $bulletin_id = $bulletin->id;
            $checklists = $bulletins[$i]['checklist'];

            DB::update("update exit_clearance_check_lists set deleted_at=? where bulletin_id=?", [$today, $bulletin_id]);
            for ($j = 0; $j < count($checklists); $j++) {
                $checker = User::find($checklists[$j]['checked_id']);

                DB::update("UPDATE exit_clearance_check_lists
                SET
                    bulletin_id=?,
                    questionnaire=?,
                    is_checked=?,
                    checked_id=?,
                    checked_code=?,
                    emp_name=?,
                    \"position\"=?,
                    ordinal=?,
                    maker=?,
                    deleted_at=null
                WHERE
                    bulletin_id=? and questionnaire=?", [
                    $bulletin_id,
                    $checklists[$j]['questionnaire'],
                    $checklists[$j]['is_checked'] = "Unchecked",
                    $checklists[$j]['checked_id'],
                    $checker->card_id,
                    $checker->name,
                    $checker->position,
                    $checklists[$j]['ordinal'],
                    session('userid'),
                    $bulletin_id,
                    $checklists[$j]['questionnaire'],
                ]);
            }
        }

        $signatures = $request->signatures;
        DB::update("update exit_clearance_signatures set deleted_at=?,delby=? where exit_id=?", [$today, session('userid'), $exitClearace->id]);
        for ($i = 0; $i < count($signatures); $i++) {
            $count = DB::select("select count(*) as c from exit_clearance_signatures WHERE exit_id=? and sign_title=? and signed_id=?;", [$request->id, $signatures[$i]['sign_title'], $signatures[$i]['signed_id']])[0]->c;

            if ($count === 0) {
                $signature = new ExitClearanceSignature();
                $signature->exit_id = $request->id;
                $signature->sign_title = $signatures[$i]["sign_title"];
                $signature->signed_id = $signatures[$i]["signed_id"];
                $approver = User::find($signatures[$i]["signed_id"]);
                $signature->signed_code = $approver->card_id;
                $signature->emp_name = $approver->name;
                $signature->position = $approver->position;
                if ($signatures[$i]["sign_title"] === "Personnel Officer") {
                    //Personnel officer are the one who prepare
                    $signature->is_signed = true;
                    $signature->signed_date = $today;
                } else {
                    $signature->is_signed = false;
                }

                $signature->ordinal = $signatures[$i]['ordinal'];
                $signature->maker = session('userid');
                $signature->save();
            } else {
                $approver = User::find($signatures[$i]["signed_id"]);

                DB::update("UPDATE exit_clearance_signatures
                SET
                    sign_title=?,
                    signed_id=?,
                    signed_code=?,
                    emp_name=?,
                    \"position\"=?,
                    is_signed=false,
                    ordinal=?,
                    signed_date=null,
                    delby=null,
                    maker=?,
                    deleted_at=null,
                    updated_at=?
                WHERE exit_id=? and sign_title=? and signed_id=? and \"sign_title\"<>'Personnel Officer';",
                    [
                        $signatures[$i]["sign_title"],
                        $signatures[$i]["signed_id"],
                        $approver->card_id,
                        $approver->name,
                        $approver->position,
                        $signatures[$i]['ordinal'],
                        session('userid'),
                        $today,
                        $request->id,
                        $signatures[$i]["sign_title"],
                        $signatures[$i]["signed_id"],
                    ]);

                DB::update("UPDATE exit_clearance_signatures
                    SET
                        sign_title=?,
                        signed_id=?,
                        signed_code=?,
                        emp_name=?,
                        \"position\"=?,
                        is_signed=true,
                        ordinal=?,
                        signed_date=?,
                        delby=null,
                        maker=?,
                        deleted_at=null,
                        updated_at=?
                    WHERE exit_id=? and sign_title=? and signed_id=? and \"sign_title\"='Personnel Officer';",
                    [
                        $signatures[$i]["sign_title"],
                        $signatures[$i]["signed_id"],
                        $approver->card_id,
                        $approver->name,
                        $approver->position,
                        $signatures[$i]['ordinal'],
                        $today,
                        session('userid'),
                        $today,
                        $request->id,
                        $signatures[$i]["sign_title"],
                        $signatures[$i]["signed_id"],
                    ]);
            }

        }

        // Add sending Email to Queue Job
        $emails = DB::select("select * from get_notification_email(?)", [$exitClearace->id]);
        foreach ($emails as $email) {
            dispatch(new Jobs($email));

            //SendMailHelper::sendMailNotification($email->re_email, ['subject' => 'subject', 'body' => 'body']);
        }

        return ['result' => 'success', 'msg' => $exitClearace->name . ' Lease Management have been update', 'data' => $exitClearace->id];
    }

    public function editExitClearance(Request $request)
    {
        if (!RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            //return redirect to authourized
            return ['result' => 'error', 'msg' => 'Unauthorized Action', 'data' => ''];
        }

        $operation_done = DB::select("select id from exit_clearance_check_lists eccl where bulletin_id in (select id from exit_clearance_bulletins ecb where exit_id=?) and is_checked in ('Checked','Unavailable');", [$request->id]);
        if (count($operation_done) > 0) {
            //return redirect to authourized
            return ['result' => 'error', 'msg' => 'There are already operation on this request, Cannot be update', 'data' => false];
        }

        $exitClearace = ExitClearance::find($request->id);

        $bulletins = DB::select("select
                            ecb.id,
                            ecb.emp_name,
                            ecb.checked_id,
                            b.id mvl_id,
                            b.abbreviation,
                            b.name_en,
                            b.name_kh,
                            b.\"type\",
                            b.value,
                            b.ordinal,
                            b.parent_mvl
                        from exit_clearance_bulletins ecb inner join mainvaluelists b
                        on ecb.questionnaire=b.id
                        where ecb.exit_id=? and ecb.deleted_at is null;", [$request->id]);

        $checklists = [];
        foreach ($bulletins as $bulletin) {
            $checklist = DB::select("select
                                eccl.id,
                                eccl.emp_name,
                                eccl.checked_id,
                                c.id mvl_id,
                                c.abbreviation,
                                c.name_en,
                                c.name_kh,
                                c.\"type\",
                                c.value,
                                c.ordinal,
                                c.parent_mvl,
                                eccl.is_checked
                            from exit_clearance_check_lists eccl inner join mainvaluelists c
                            on eccl.questionnaire=c.id
                            where eccl.bulletin_id=? and eccl.deleted_at is null", [$bulletin->id]);
            $checklists[] = ["bulletin" => $bulletin, "checklists" => $checklist];
        }

        $signatures = ExitClearanceSignature::where('exit_id', $exitClearace->id)->get();

        $data = ["exitClearace" => $exitClearace, "checkLists" => $checklists, 'signatures' => $signatures];

        return ['result' => 'success', 'msg' => 'Editing', 'data' => $data];
    }

    public function removeExitClearance(Request $request)
    {
        if (!RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            //return redirect to authourized
            return ['result' => 'error', 'msg' => 'Unauthorized Action', 'data' => ''];
        }

        $today = Carbon::now(new DateTimeZone('Asia/Phnom_Penh'));

        DB::update("update exit_clearances set deleted_at=?,delby=? where id=?", [$today, session('userid'), $request->id]);

        return ['result' => 'success', 'msg' => 'Remove Completed', 'data' => null];
    }

    public function getExitClearancePDF(Request $request)
    {
        if (!RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            //return redirect to authourized
            return ['result' => 'error', 'msg' => 'Unauthorized Action', 'data' => ''];
        }

        $data = ExitClearanceHelper::makeExitClearancePDF($request->id);

        return View('exit_clearance_pdf.exit_clearance_pdf')
            ->with('storePath', $data['filePath'])
            ->with('id', $request->id);
    }

    public function getUserImage(Request $request)
    {
        if (!RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            //return redirect to authourized
            return ['result' => 'error', 'msg' => 'Unauthorized Action', 'data' => ""];
        }

        $photo = "";
        $userid = $request->userid;

        if (Storage::disk('local')->exists('/public/files/userimg/' . $userid . 'compress.jpg')) {
            $photo = base64_encode(Storage::disk('local')->get('/public/files/userimg/' . $userid . 'compress.jpg'));
        } else {
            $photo = base64_encode(file_get_contents('files/userimg/nophoto.jpg'));
        }

        return [
            'result' => 'success',
            'msg' => "",
            'data' => $photo,
        ];
    }

    public function viewUserPhoto(Request $request)
    {
        if (!RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            //return redirect to authourized
            return ['result' => 'error', 'msg' => 'Unauthorized Action', 'data' => ''];
        }

        $userid = $request->userid;
        $user = User::find($userid);
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

    public function getExitEmployeeInfo(Request $request)
    {
        if (!RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            //return redirect to authourized
            return ['result' => 'error', 'msg' => 'Unauthorized Action', 'data' => ''];
        }

        $employee = User::where('card_id', $request->card_id)->where('card_id', '<>', '')->first();

        return [
            'result' => 'success',
            'msg' => "",
            'data' => $employee,
        ];
    }

    public function getUsers(Request $request)
    {
        if (!RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            //return redirect to authourized
            return ['result' => 'error', 'msg' => 'Unauthorized Action', 'data' => ''];
        }

        $user = DB::select(
            'select * from users u where ("name" like ? or card_id like ?) and deleted_at is null and not position is null',
            ['%' . $request->search . '%', '%' . $request->search . '%']);

        return [
            'result' => 'success',
            'msg' => "",
            'data' => $user,
        ];
    }

    public function existUser(Request $request)
    {
        if (!RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            //return redirect to authourized
            return ['result' => 'error', 'msg' => 'Unauthorized Action', 'data' => ''];
        }

        $exit_user = User::where('card_id', $request->card_id)->get();

        if (count($exit_user) <= 0) {
            return ['result' => 'error', 'msg' => "Card ID = $request->card_id Does not exist in system", 'data' => false];
        } else {
            return ['result' => 'success', 'msg' => "", 'data' => true];
        }
    }

    public function getCheckListRemark(Request $request)
    {
        if (!RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            //return redirect to authourized
            return ['result' => 'error', 'msg' => 'Unauthorized Action', 'data' => ''];
        }

        $check_list_id = $request->id;

        $check_list = ExitClearanceCheckList::find($check_list_id);
        $remark = $check_list->remarks;

        return ['result' => 'success', 'msg' => "", 'data' => $remark];
    }

    public function saveCheckListRemark(Request $request)
    {
        if (!RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            //return redirect to authourized
            return ['result' => 'error', 'msg' => 'Unauthorized Action', 'data' => ''];
        }

        $check_list_id = $request->check_id;

        $check_list = ExitClearanceCheckList::find($check_list_id);
        $check_list->remarks = $request->htmlContent;
        $check_list->save();

        return ['result' => 'success', 'msg' => "Save Completed", 'data' => ''];
    }
}
