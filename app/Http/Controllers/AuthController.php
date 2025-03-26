<?php
namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use DateTimeZone;
use Exception;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function login()
    {
        return View('Auth.login');
    }

    public function authenticate(Request $request)
    {
        $user = User::where('username', $request->username)->orWhere('card_id', $request->username)->first(); //username is uniqure

        $now = Carbon::now(new DateTimeZone('Asia/Phnom_Penh'));

        if ($user->lock_until != null) {
            if (Carbon::parse($user->lock_until) > $now) {
                return ['result' => 'error', 'msg' => "Your username have been lock until " . Carbon::parse($user->lock_until)->format('M, d Y H:i:s'), 'data' => null];
            }
        }

        if (! $user || ! Hash::check($request->password, $user->password)) {
            if ($user->attempted == 3) {
                $lockTime = Carbon::now(new DateTimeZone('Asia/Phnom_Penh'))->addMinutes(15);
                DB::update('UPDATE users SET lock_until=?,attempted=0 WHERE id=?', [$lockTime, $user->id]);
            } else {
                DB::update('UPDATE users SET attempted=attempted+1 WHERE id=?', [$user->id]);
            }

            return response(['result' => 'error', 'msg' => 'Invalid username or password', 'data' => null]);
        }

        DB::update('UPDATE users SET lock_until=null,attempted=0 WHERE id=?', [$user->id]);

        //$user->tokens()->delete();
        $token = $user->createToken('myapptoken')->plainTextToken;
        //Carbon::now(new DateTimeZone('Asia/Phnom_Penh'));
        $sessionlife = Config::get('session.lifetime');

        $isGuardian = 0;

        Session(['SessionEnd' => Carbon::now(new DateTimeZone('Asia/Phnom_Penh'))->addMinutes($sessionlife)]);
        Session(['AuthToken' => $token]);
        Session(['userid' => $user->id]);
        Session(['username' => $user->name]);
        Session(['userloginname' => $user->username]);
        Session(['isGuardian' => $isGuardian]);

        $roles = DB::select('select r.id,r."is_admin" from role_user ru inner join roles r on ru.role_id=r.id where ru.user_id=?', [$user->id]);
        Session(['userroles' => json_encode($roles)]);

        return response(['result' => 'success', 'msg' => '', 'data' => '']);
    }

    public function logOut(Request $request)
    {
        $userid = auth()->user()->id;
        $user   = User::find($userid);
        $user->tokens()->delete();

        $request->session()->forget('AuthToken');

        return redirect('login');
    }

    public function resetPassword(Request $request)
    {
        if (session()->has('AuthToken') == false) {
            return ['result' => 'error', 'msg' => 'Loging Required', 'data' => ''];
        }

        $user = User::find(session('userid'));

        $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9])(?=.{8,}).*$/';

        if (! preg_match($pattern, $request->newpassword)) {
            return [
                'result' => 'error',
                'msg'    => 'Your password must be a strong password.',
                'data'   => '',
            ];
        }

        if (! (Hash::check($request->currentpassword, $user->password))) {
            // The passwords matches
            return [
                'result' => 'error',
                'msg'    => 'Your current password does not matches with the password.',
                'data'   => '',
            ];
        }

        if (strcmp($request->currentpassword, $request->newpassword) == 0) {
            // Current password and new password same
            return [
                'result' => 'error',
                'msg'    => 'New Password cannot be same as your current password.',
                'data'   => '',
            ];
        }

        $user->password       = bcrypt($request->newpassword);
        $user->maker          = session('userid');
        $user->is_first_login = 0;
        $user->save();

        Session(['is_first_login' => 0]);

        return [
            'result' => 'success',
            'msg'    => 'Password have been reset',
            'data'   => '',
        ];
    }

    public function destroysession()
    {
        session_destroy();
    }

    #region google
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleuser = Socialite::driver('google')->user();
            $user       = User::where('google_id', $googleuser->id)->orWhere('username', $googleuser->email)->first();

            if ($user) {
                //Login//
                $token       = $user->createToken('myapptoken')->plainTextToken;
                $sessionlife = Config::get('session.lifetime');
                $isGuardian  = 0;
                /*$GuardianRole = DB::select('SELECT U.id FROM roles R INNER JOIN role_user RU ON R.id=RU.role_id AND R.name=?
                INNER JOIN users U ON U.id=RU.user_id AND U.id=?', ['Guardian', $user->id]);

                if (count($GuardianRole) > 0) {
                $isGuardian = 1;
                }*/

                if ($user->google_id == null) {
                    $user->google_id = $googleuser->id;
                    $user->save();
                }

                Session(['SessionEnd' => Carbon::now(new DateTimeZone('Asia/Phnom_Penh'))->addMinutes($sessionlife)]);
                Session(['AuthToken' => $token]);
                Session(['userid' => $user->id]);
                Session(['username' => $user->name]);
                Session(['userloginname' => $user->username]);
                //Session(['permitCampus' => $user->username]);
                Session(['isGuardian' => $isGuardian]);
                /////////

                return redirect('/home/index');
            } else {
                $newUser = User::create([
                    'name'      => $googleuser->name,
                    'email'     => $googleuser->email,
                    'username'  => $googleuser->email,
                    'google_id' => $googleuser->id,
                    'password'  => bcrypt('secretM@5ter'),
                ]);

                //Login//
                $token        = $newUser->createToken('myapptoken')->plainTextToken;
                $sessionlife  = Config::get('session.lifetime');
                $isGuardian   = 0;
                $GuardianRole = DB::select('SELECT U.id FROM roles R INNER JOIN role_user RU ON R.id=RU.role_id AND R.name=?
                INNER JOIN users U ON U.id=RU.user_id AND U.id=?', ['Guardian', $newUser->id]);

                if (count($GuardianRole) > 0) {
                    $isGuardian = 1;
                }

                Session(['SessionEnd' => Carbon::now(new DateTimeZone('Asia/Phnom_Penh'))->addMinutes($sessionlife)]);
                Session(['AuthToken' => $token]);
                Session(['userid' => $newUser->id]);
                Session(['username' => $newUser->name]);
                Session(['userloginname' => $newUser->username]);
                Session(['isGuardian' => $isGuardian]);
                /////////

                return redirect('/home/index');
            }
        } catch (Exception $e) {
            //dd($e->getMessage());
            dd($e);
        }
    }
    #endregion
}
