<?php

namespace App\Http\Controllers;

use App\Helper\ExitClearanceHelper;
use App\Helper\RBAC;
use App\Models\ExitClearance;
use App\Models\ExitClearanceBulletin;
use App\Models\ExitClearanceCheckList;
use App\Models\Mainvaluelist;
use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SocialController extends Controller
{
    public function getUserImage(Request $request)
    {
        $photo = "";

        if (session('isGuardian') == 0) {
            if (Storage::disk('local')->exists('/public/files/userimg/' . $request->userid . 'compress.jpg')) {
                $photo = base64_encode(Storage::disk('local')->get('/public/files/userimg/' . $request->userid . 'compress.jpg'));
            } else {
                $photo = base64_encode(Storage::disk('local')->get('/public/files/userimg/nophoto.jpg'));
                //$photo = "";
            }
        } else {
            if (Storage::disk('local')->exists('/public/files/studentimg/' . session('userloginname') . 'compress.jpg')) {
                $photo = base64_encode(Storage::disk('local')->get('/public/files/studentimg/' . session('userloginname') . 'compress.jpg'));
            } else {
                $photo = base64_encode(Storage::disk('local')->get('/public/files/userimg/nophoto.jpg'));
                //$photo = "";
            }
        }

        return response(['result' => 'success', 'msg' => '', 'data' => $photo]);
    }

    public function getSelectList(Request $request)
    {
        $result = Mainvaluelist::where('type', $request->mvlType)->get();

        return ['result' => 'success', 'msg' => '', 'data' => $result];
    }

    public function isAccessible(Request $request)
    {
        $permissions = $request->permissiondata;
        $response = [];
        foreach ($permissions as $permission) {
            $accessible = RBAC::isAccessible($permission['permission']);
            $response[] = ["index" => $permission['index'], "permission" => $permission['permission'], "accessible" => $accessible];
        }

        return response(['result' => 'success', 'msg' => '', 'data' => $response]);
    }

    public function getNotification()
    {
        $userid = session('userid');

        $notification = DB::select("select distinct ec.id,ec.emp_id,ec.card_id,ec.\"name\",ec.last_working_date,ec.maker  from
        exit_clearances ec inner join exit_clearance_bulletins ecb on ec.id=ecb.exit_id
        inner join exit_clearance_check_lists eccl on ecb.id=eccl.bulletin_id
        where ec.is_checked_completed=false and ec.deleted_at is null and ec.is_rejected=false and ec.is_completed=false
        and eccl.checked_id=? and eccl.is_checked='Unchecked'", [$userid]);

        $approver = DB::select("select
                                re_signature_id signature_id,
                                re_exit_id exit_id,
                                re_action \"action\",
                                re_exit_name exit_name,
                                re_status status,
                                re_emp_id emp_id,
                                re_card_id citext,
                                re_ordinal card_id,
                                last_working_date
                        from get_exit_approve_notification(?)", [$userid]);

        $data = array();
        for ($i = 0; $i < count($notification); $i++) {

            if ($notification[$i]->emp_id) {
                if (Storage::disk('local')->exists('/public/files/userimg/' . $notification[$i]->emp_id . 'compress.jpg')) {
                    $photo = base64_encode(Storage::disk('local')->get('/public/files/userimg/' . $notification[$i]->emp_id . 'compress.jpg'));
                } else {
                    $photo = base64_encode(file_get_contents('files/userimg/nophoto.jpg'));
                }

            } else {
                $photo = base64_encode(file_get_contents('files/userimg/nophoto.jpg'));
            }

            $data[] = [
                "id" => $notification[$i]->id,
                "card_id" => $notification[$i]->card_id,
                "type" => "Check List",
                "name" => $notification[$i]->name,
                "last_working_date" => $notification[$i]->last_working_date,
                "photo" => $photo,
                "signature_id" => null,
                "action" => null,
            ];
        }

        for ($i = 0; $i < count($approver); $i++) {
            if ($approver[$i]->emp_id) {
                if (Storage::disk('local')->exists('/public/files/userimg/' . $approver[$i]->emp_id . 'compress.jpg')) {
                    $photo = base64_encode(Storage::disk('local')->get('/public/files/userimg/' . $approver[$i]->emp_id . 'compress.jpg'));
                } else {
                    $photo = base64_encode(file_get_contents('files/userimg/nophoto.jpg'));
                }

            } else {
                $photo = base64_encode(file_get_contents('files/userimg/nophoto.jpg'));
            }

            $data[] = [
                "id" => $approver[$i]->exit_id,
                "card_id" => $approver[$i]->card_id,
                "type" => "Approver",
                "name" => $approver[$i]->exit_name,
                "last_working_date" => $approver[$i]->last_working_date,
                "photo" => $photo,
                "signature_id" => $approver[$i]->signature_id,
                "action" => $approver[$i]->action,
            ];
        }

        return ['result' => 'success', 'msg' => '', 'data' => $data];
    }

    public function getCheckerForm(Request $request)
    {
        $userid = session('userid');
        $exit_id = $request->exit_id;

        $form_data = DB::select("select * from get_exit_clearance_approve_data(?,?)", [$exit_id, $userid]);
        $exit_clearance = ExitClearance::find($exit_id);

        return View('exit_clearance.ext_clearance_approve_form')->with('form_data', $form_data)->with('exit_id', $exit_id)->with('exit_clearance', $exit_clearance);
    }

    public function getApprovalForm(Request $request)
    {
        $data = ExitClearanceHelper::makeExitClearancePDF($request->exit_id);
        $signature_id = $request->signature_id;
        $action = $request->action;

        return View('exit_clearance.final_approver_form')
            ->with('storePath', $data['filePath'])
            ->with('exit_id', $request->exit_id)
            ->with('signature_id', $signature_id)
            ->with('action', $action);
    }

    public function getEmployeeList(Request $request)
    {
        $start = $request->start;
        $length = $request->length;
        $searchValue = $request->search['value'] == null ? "" : $request->search['value'];
        $orderColumn = $request->columns[$request->order[0]['column']]['name']; //Name of order column
        $AscDesc = $request->order[0]['dir']; //asc or desc

        $recordsTotal = 0;
        $recordsFiltered = 0;

        $user = [];

        $user = DB::select("select re_id id,re_card_id card_id,re_name \"name\",re_position \"position\",re_total_record total_record,re_filter_record filter_record from get_employee_list(?,?,?,?,?);", [$searchValue, $orderColumn, $AscDesc, $start, $length]);

        if (count($user) !== 0) {
            $recordsTotal = $user[0]->total_record;
            $recordsFiltered = $user[0]->filter_record;
        }

        return ['data' => $user, 'draw' => $request->draw, 'recordsTotal' => $recordsTotal, 'recordsFiltered' => $recordsFiltered];
    }

    public function checkListDelegation(Request $request)
    {
        $userid = $request->user['id'];
        $card_id = $request->user['card_id'];
        $name = $request->user['name'];
        $position = $request->user['position'];
        $checklist_id = $request->checklist_id;
        DB::update("update exit_clearance_check_lists
                    set
                        checked_id=?,
                        checked_code=?,
                        emp_name=?,
                        \"position\"=?,
                        maker=?
                    where id=?",
            [
                $userid,
                $card_id,
                $name,
                $position,
                session('userid'),
                $checklist_id,
            ]
        );

        $check_list = ExitClearanceCheckList::find($checklist_id);
        $bulletin = ExitClearanceBulletin::find($check_list->bulletin_id);
        $exit_id = $bulletin->exit_id;

        $form_data = DB::select("select * from get_exit_clearance_approve_data(?,?)", [$exit_id, session('userid')]);

        return ['result' => 'success', 'msg' => 'Delegation Success', 'data' => $form_data];
    }

    public function saveApproveCheckList(Request $request)
    {
        $form_data = $request->form_data;
        $date = Carbon::now(new DateTimeZone('Asia/Phnom_Penh'));
        $exit_id = 0;

        foreach ($form_data as $bulletin) {
            $check_lists = $bulletin['check_list'];
            $exit_id = $bulletin['exit_id'];
            foreach ($check_lists as $check_list) {
                DB::update("update exit_clearance_check_lists
                            set
                                checked_id=?,
                                checked_code=?,
                                emp_name=?,
                                \"position\"=?,
                                is_checked=?,
                                checked_date=?,
                                maker=?,
                                updated_at=?
                            where
                                id=?", [
                    $check_list["checked_id"],
                    $check_list["checked_code"],
                    $check_list["emp_name"],
                    $check_list["position"],
                    $check_list["is_checked"],
                    $date,
                    session('userid'),
                    $date,
                    $check_list["id"],
                ]);
            }

            ExitClearanceHelper::bulletinComplete($bulletin["id"], $date);
        }

        ExitClearanceHelper::exit_check_completed($exit_id, $date);

        return ['result' => 'success', 'msg' => 'Completed Saving Check List', 'data' => ''];
    }

    public function saveApprove(Request $request)
    {
        $date = Carbon::now(new DateTimeZone('Asia/Phnom_Penh'));
        $signatureId = $request->signatureId;
        $action = $request->action;
        $exit_id = $request->exit_id;
        DB::update("update exit_clearance_signatures set is_signed=true,signed_date=? where id=?", [$date, $signatureId]);

        $remain_signature = DB::select("select count(*) remain from exit_clearance_signatures ecs where exit_id=? and deleted_at is null and is_signed=false", [$exit_id])[0];

        if ($remain_signature->remain > 0) {
            DB::update("update exit_clearances set status=? where id=?", [$action, $exit_id]);
        } else {
            DB::update("update exit_clearances set status='Completed',is_completed=true,completed_date=? where id=?", [$date, $exit_id]);
        }

        return ['result' => 'success', 'msg' => "$action completed", 'data' => ''];
    }
}
