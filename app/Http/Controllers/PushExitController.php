<?php
namespace App\Http\Controllers;

use App\Helper\RBAC;
use App\Models\Mainvaluelist;
use Error;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

class PushExitController extends Controller
{
    public function index()
    {
        if (session()->has('AuthToken') == false) {
            return redirect('login');
        }

        if (! RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            //return redirect to authourized
            return View('social.unauthorized');
        }

        return View('push_exit.index');
    }

    public function pushDeactivate()
    {
        if (! RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            return ['result' => 'error', 'msg' => 'Unauthorized Action', 'data' => ''];
        }

        $exitRecord = DB::select('select card_id as cardid,last_working_date as lastworkingdate from exit_clearances where is_completed=true and deleted_at is null');

        $jsonData = json_encode($exitRecord, JSON_UNESCAPED_UNICODE);

        Storage::disk('exitPush')->put('exit.json', $jsonData);

        $content = Storage::disk('exitPush')->get('exit.json');

        $headers = [
            // 'Content-Type' => 'application/json',
            'Authorization' => 'Bearer 10993|luJ2oS4VUWyMn4ElAOWCccdQK8ninLRXfd1AY0Zp',
        ];

        $URLs = Mainvaluelist::where('type', 'Deactivate URL')->get();

        foreach ($URLs as $u) {
            try {
                $response = Http::withHeaders($headers)
                    ->attach('file', $content, 'exit.json')
                    ->post($u->value);
            } catch (Error $e) {
                Log::error($e->getMessage());
            }

            // $response = Http::attach('file', $content, 'exit.json')->post($u->value);
        }

        return ['result' => 'success', 'msg' => '', 'data' => ""];
    }
}
