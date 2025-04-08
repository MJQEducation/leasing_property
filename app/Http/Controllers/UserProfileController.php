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
    public function dashboard()
    {   
        if (session()->has('AuthToken') == false) {
            return redirect('login');
        }

        if (!RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            //return redirect to authourized
            return View('social.unauthorized');
        }

        $data = DB::select('
        SELECT s.abbreviation,
        MIN(s.name_en) AS name_en,
        COUNT(s.abbreviation) AS abbreviation_count
        FROM stores AS s
        WHERE s.status = true
        AND s.is_sub=false
        AND s.abbreviation != \'sub\'
        GROUP BY s.abbreviation
 
    
        UNION
    
        SELECT \'sub\' AS abbreviation,
               \'RETAIL F&B\' AS name_en,
               COUNT(id) AS abbreviation_count
        FROM substore
        WHERE status = true;
    ');



    $dataSubStore = DB::select('
    SELECT ss.abbreviation,
        MIN(ss.name_en) AS name_en,
        COUNT(ss.abbreviation) AS abbreviation_count
        FROM substore AS ss
        WHERE ss.status = true
        GROUP BY ss.abbreviation;
    ');


    $GraphData = DB::select("
    SELECT
        COUNT(DISTINCT ss.id) AS Retail,
        COUNT(DISTINCT c.store_code) AS Retail_LeaseOut,

        -- Retail Amount Paid
        COALESCE(
            (SELECT SUM(payments.amount_paid)
             FROM payments
             JOIN public.leasings l ON l.id = payments.leasing_id
             LEFT JOIN public.stores s ON l.store_code = s.store_code
             WHERE s.abbreviation IS NULL), 0
        ) AS Retail_amount_paid,

        -- Building Counts & Amount Paid
        (SELECT COUNT(*) FROM stores AS s WHERE s.abbreviation = 'bu' AND s.status = '1') AS Building,
        (SELECT COUNT(*) FROM stores AS s 
         JOIN contracts AS c ON c.store_code = s.store_code 
         WHERE s.abbreviation = 'bu' AND s.status = '1') AS Building_Leaseout,
        COALESCE(
            (SELECT SUM(p.amount_paid) 
             FROM payments AS p
             JOIN leasings AS l ON l.id = p.leasing_id
             JOIN contracts AS c ON c.id = l.contract_id
             LEFT JOIN stores AS s ON s.store_code = c.store_code
             LEFT JOIN substore AS ss ON ss.substore_code = c.store_code
             WHERE COALESCE(s.abbreviation, ss.abbreviation) = 'SM'), 0
        ) AS Building_amount_paid,

        -- Land Counts & Amount Paid
        (SELECT COUNT(*) FROM stores AS s WHERE s.abbreviation = 'land' AND s.status = '1') AS Land,
        (SELECT COUNT(*) FROM stores AS s 
         JOIN contracts AS c ON c.store_code = s.store_code 
         WHERE s.abbreviation = 'land' AND s.status = '1') AS Land_Leaseout,
        COALESCE(
            (SELECT SUM(p.amount_paid) 
             FROM payments AS p
             JOIN leasings AS l ON l.id = p.leasing_id
             JOIN contracts AS c ON c.id = l.contract_id
             LEFT JOIN stores AS s ON s.store_code = c.store_code
             LEFT JOIN substore AS ss ON ss.substore_code = c.store_code
             WHERE COALESCE(s.abbreviation, ss.abbreviation) = 'land'), 0
        ) AS Land_amount_paid,

        -- MJQ Counts & Amount Paid
        (SELECT COUNT(*) FROM stores AS s WHERE s.abbreviation = 'mjq' AND s.status = '1') AS MJQ,
        (SELECT COUNT(*) FROM stores AS s 
         JOIN contracts AS c ON c.store_code = s.store_code 
         WHERE s.abbreviation = 'mjq' AND s.status = '1') AS MJQ_Leaseout,
        COALESCE(
            (SELECT SUM(p.amount_paid) 
             FROM payments AS p
             JOIN leasings AS l ON l.id = p.leasing_id
             JOIN contracts AS c ON c.id = l.contract_id
             LEFT JOIN stores AS s ON s.store_code = c.store_code
             LEFT JOIN substore AS ss ON ss.substore_code = c.store_code
             WHERE COALESCE(s.abbreviation, ss.abbreviation) = 'mjq'), 0
        ) AS MJQ_amount_paid

    FROM substore AS ss
    LEFT JOIN contracts AS c ON c.store_code = ss.substore_code
    WHERE ss.status = '1';
");





    $FBGraph = DB::select("
    SELECT
        COUNT(DISTINCT CASE WHEN ss.abbreviation = 'SM' THEN ss.id END) AS \"SmartMart\",
        COUNT(DISTINCT CASE WHEN ss.abbreviation = 'SM' AND c.store_code IS NOT NULL THEN c.store_code END) AS \"Retail_LeaseOut_SM\",

        COUNT(DISTINCT CASE WHEN ss.abbreviation = 'RC' THEN ss.id END) AS \"RC\",
        COUNT(DISTINCT CASE WHEN ss.abbreviation = 'RC' AND c.store_code IS NOT NULL THEN c.store_code END) AS \"Retail_LeaseOut_RC\",

        COUNT(DISTINCT CASE WHEN ss.abbreviation = 'AFC' THEN ss.id END) AS \"AFC\",
        COUNT(DISTINCT CASE WHEN ss.abbreviation = 'AFC' AND c.store_code IS NOT NULL THEN c.store_code END) AS \"Retail_LeaseOut_AFC\",

        COUNT(DISTINCT CASE WHEN ss.abbreviation = 'SS' THEN ss.id END) AS \"SS\",
        COUNT(DISTINCT CASE WHEN ss.abbreviation = 'SS' AND c.store_code IS NOT NULL THEN c.store_code END) AS \"Retail_LeaseOut_SS\",

        COUNT(DISTINCT CASE WHEN ss.abbreviation = 'OSR' THEN ss.id END) AS \"OSR\",
        COUNT(DISTINCT CASE WHEN ss.abbreviation = 'OSR' AND c.store_code IS NOT NULL THEN c.store_code END) AS \"Retail_LeaseOut_OSR\"
    FROM substore AS ss
    LEFT JOIN contracts AS c ON c.store_code = ss.substore_code
    WHERE ss.status = '1';
    ");

    $totalCustomerResult = DB::select("SELECT COUNT(id) AS totalCustomer FROM customers");

    $totalCustomer = $totalCustomerResult[0]->totalcustomer ?? 0;    ; 


    $revenueResult = DB::select("SELECT SUM(p.final_charge) AS totalRevenue FROM payments p");
    $revenue = $revenueResult[0]->totalrevenue ?? 0; 

    $avgRevenueResult = DB::select("
        SELECT
        CASE
        WHEN last_month.total_payment = 0 OR last_month.total_payment IS NULL
        THEN NULL
        ELSE ROUND(((this_month.total_payment - last_month.total_payment) / last_month.total_payment) * 100, 2)
        END || '%' AS percentage_change
        FROM
        (SELECT SUM(final_charge) AS total_payment
         FROM payments
         WHERE DATE_TRUNC('month', payment_date) = DATE_TRUNC('month', CURRENT_DATE)) AS this_month,

        (SELECT SUM(final_charge) AS total_payment
         FROM payments
         WHERE DATE_TRUNC('month', payment_date) = DATE_TRUNC('month', CURRENT_DATE - INTERVAL '1 month')) AS last_month;
    ");

    $avgRevenuetolastmonth = $avgRevenueResult[0]->percentage_change ?? '0%'; // Extract value or fallback to '0%'


    $totalPropResult = DB::select("
        SELECT 
        (SELECT COUNT(DISTINCT abbreviation) FROM stores WHERE is_sub = false) +
        (SELECT COUNT(DISTINCT abbreviation) FROM substore)
        AS totalProperty
    ");
    $totalProp = $totalPropResult[0]->totalproperty ?? 0;

    $thismonth = DB::select("
    SELECT SUM(final_charge) AS total_payment
    FROM payments
    WHERE DATE_TRUNC('month', payment_date) = DATE_TRUNC('month', CURRENT_DATE)
");

$thismonthrevenue = $thismonth[0]->total_payment ?? 0;



    $lastmonth=DB::select("
        SELECT SUM(final_charge) AS total_payment
        FROM payments
        WHERE DATE_TRUNC('month', payment_date) = DATE_TRUNC('month', CURRENT_DATE - INTERVAL '1 month')
    ");
        $lastmonthRevenue = $lastmonth[0]->total_payment ?? 0; 


        
    $profitprop = DB::select("
        SELECT s.name_en AS store_name, p.payment_date, p.final_charge,p2.estimated_income
        FROM payments p
        LEFT JOIN leasings l ON l.id = p.leasing_id
        INNER JOIN stores s ON l.store_code = s.store_code
        join projection p2 on l.contract_id = p2.contract_id and p2.projection_date=l.alert_date


        UNION

        SELECT s2.name_en AS store_name, p.payment_date, p.final_charge,p2.estimated_income
        FROM payments p
        LEFT JOIN leasings l ON l.id = p.leasing_id
        INNER JOIN substore s2 ON l.store_code = s2.substore_code
        join projection p2 on l.contract_id = p2.contract_id and p2.projection_date=l.alert_date

    ");

    $LastmonthEstimatedIncome = DB::select("
        
                SELECT s.name_en AS store_name, p.payment_date, p.final_charge,p2.estimated_income
        FROM payments p
        LEFT JOIN leasings l ON l.id = p.leasing_id
        INNER JOIN stores s ON l.store_code = s.store_code
        join projection p2 on l.contract_id = p2.contract_id and p2.projection_date=l.alert_date
        WHERE p.payment_date >= date_trunc('month', current_date - interval '1' month)
        AND p.payment_date < date_trunc('month', current_date)


        UNION

        SELECT s2.name_en AS store_name, p.payment_date, p.final_charge,p2.estimated_income
        FROM payments p
        LEFT JOIN leasings l ON l.id = p.leasing_id
        INNER JOIN substore s2 ON l.store_code = s2.substore_code
        join projection p2 on l.contract_id = p2.contract_id and p2.projection_date=l.alert_date
        WHERE p.payment_date >= date_trunc('month', current_date - interval '1' month)
        AND p.payment_date < date_trunc('month', current_date)




    ");

     
        return View('Dashboard.index',compact('LastmonthEstimatedIncome','profitprop','thismonthrevenue','lastmonthRevenue','data','dataSubStore','GraphData','FBGraph','totalCustomer','revenue','avgRevenuetolastmonth','totalProp'));
    }
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
        SELECT s.abbreviation,
        MIN(s.name_en) AS name_en,
        COUNT(s.abbreviation) AS abbreviation_count
        FROM stores AS s
        WHERE s.status = true
        AND s.is_sub=false
        AND s.abbreviation != \'sub\'
        GROUP BY s.abbreviation
 
    
        UNION
    
        SELECT \'sub\' AS abbreviation,
               \'RETAIL F&B\' AS name_en,
               COUNT(id) AS abbreviation_count
        FROM substore
        WHERE status = true;
    ');



    $dataSubStore = DB::select('
    SELECT ss.abbreviation,
        MIN(ss.name_en) AS name_en,
        COUNT(ss.abbreviation) AS abbreviation_count
        FROM substore AS ss
        WHERE ss.status = true
        GROUP BY ss.abbreviation;
    ');


    $GraphData = DB::select("
SELECT
    COUNT(DISTINCT ss.id) AS Retail,
    COUNT(DISTINCT c.store_code) AS Retail_LeaseOut,
    (SELECT COUNT(*) FROM stores AS s WHERE s.abbreviation = 'bu' AND s.status = '1') AS Building,
    (SELECT COUNT(*) FROM stores AS s JOIN contracts AS c ON c.store_code = s.store_code WHERE s.abbreviation = 'bu' AND s.status = '1') AS Building_Leaseout,
    (SELECT COUNT(*) FROM stores AS s WHERE s.abbreviation = 'land' AND s.status = '1') AS Land,
    (SELECT COUNT(*) FROM stores AS s JOIN contracts AS c ON c.store_code = s.store_code WHERE s.abbreviation = 'land' AND s.status = '1') AS Land_Leaseout,
    (SELECT COUNT(*) FROM stores AS s WHERE s.abbreviation = 'mjq' AND s.status = '1') AS MJQ,
    (SELECT COUNT(*) FROM stores AS s JOIN contracts AS c ON c.store_code = s.store_code WHERE s.abbreviation = 'mjq' AND s.status = '1') AS MJQ_Leaseout
FROM substore AS ss
LEFT JOIN contracts AS c ON c.store_code = ss.substore_code
AND ss.status = '1';
");






    $FBGraph = DB::select("
    SELECT
        COUNT(DISTINCT CASE WHEN ss.abbreviation = 'SM' THEN ss.id END) AS \"SmartMart\",
        COUNT(DISTINCT CASE WHEN ss.abbreviation = 'SM' AND c.store_code IS NOT NULL THEN c.store_code END) AS \"Retail_LeaseOut_SM\",

        COUNT(DISTINCT CASE WHEN ss.abbreviation = 'RC' THEN ss.id END) AS \"RC\",
        COUNT(DISTINCT CASE WHEN ss.abbreviation = 'RC' AND c.store_code IS NOT NULL THEN c.store_code END) AS \"Retail_LeaseOut_RC\",

        COUNT(DISTINCT CASE WHEN ss.abbreviation = 'AFC' THEN ss.id END) AS \"AFC\",
        COUNT(DISTINCT CASE WHEN ss.abbreviation = 'AFC' AND c.store_code IS NOT NULL THEN c.store_code END) AS \"Retail_LeaseOut_AFC\",

        COUNT(DISTINCT CASE WHEN ss.abbreviation = 'SS' THEN ss.id END) AS \"SS\",
        COUNT(DISTINCT CASE WHEN ss.abbreviation = 'SS' AND c.store_code IS NOT NULL THEN c.store_code END) AS \"Retail_LeaseOut_SS\",

        COUNT(DISTINCT CASE WHEN ss.abbreviation = 'OSR' THEN ss.id END) AS \"OSR\",
        COUNT(DISTINCT CASE WHEN ss.abbreviation = 'OSR' AND c.store_code IS NOT NULL THEN c.store_code END) AS \"Retail_LeaseOut_OSR\"
    FROM substore AS ss
    LEFT JOIN contracts AS c ON c.store_code = ss.substore_code
    WHERE ss.status = '1';
    ");

            
        return View('users_profile.index',compact('data','dataSubStore','GraphData','FBGraph'));
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
