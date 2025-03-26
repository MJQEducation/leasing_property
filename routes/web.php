<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExitClearanceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MainvaluelistController;
use App\Http\Controllers\PushExitController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::group(['middleware' => ['web']], function () {
    Route::get('/login', [AuthController::class, 'login']);
    Route::get('/', [HomeController::class, 'index']);
    Route::get('/home/index', [HomeController::class, 'index']);

    //google auth//
    Route::get('/redirect', [AuthController::class, 'redirect']);
    Route::get('/callback', [AuthController::class, 'callback']);
    //google auth//

    #region Admin
    Route::get('/admin/viewUser', [AdminController::class, 'viewUser']);

    Route::get('/admin/viewPermission', [
        AdminController::class,
        'viewPermission',
    ]);

    Route::get('/admin/viewroles', [AdminController::class, 'viewroles']);

    Route::post('/admin/viewUserPhoto', [
        AdminController::class,
        'viewUserPhoto',
    ]);
    #endregion

    #region MVL
    Route::get('/mvl/index', [MainvaluelistController::class, 'index']);
    #endregion

    #region User Profile
    Route::get('/userprofile/Index', [UserProfileController::class, 'index']);
    #endregion

    #region exit clearance
    Route::get('/exitClearance/index', [ExitClearanceController::class, 'index']);
    Route::post('/exit_clearance/getExitClearancePDF', [ExitClearanceController::class, 'getExitClearancePDF']);
    Route::post('/ExitClearance/viewUserPhoto', [ExitClearanceController::class, 'viewUserPhoto']);
    Route::Post('/social/getCheckerForm', [SocialController::class, 'getCheckerForm']);
    Route::Post('/social/getApprovalForm', [SocialController::class, 'getApprovalForm']);
    #endregion

    #region push to other url
    Route::get('/pushexit/index', [PushExitController::class, 'index']);
    #endregion
});
