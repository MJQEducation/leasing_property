<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExitClearanceController;
use App\Http\Controllers\MainvaluelistController;
use App\Http\Controllers\PushExitController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::Post('/authenticate', [AuthController::class, 'authenticate']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/destroysession', [AuthController::class, 'destroysession']);
    Route::Post('/logout', [AuthController::class, 'logOut']);
    Route::Post('/resetPassword', [AuthController::class, 'resetPassword']);

    #region Social
    Route::Post('/social/getUserImage', [
        SocialController::class,
        'getUserImage',
    ]);

    Route::Post('/social/getSelectList', [
        SocialController::class,
        'getSelectList',
    ]);

    Route::Post('/social/isAccessible', [
        SocialController::class,
        'isAccessible',
    ]);

    Route::get('/social/myNotification', [
        SocialController::class,
        'myNotification',
    ]);

    Route::get('/Social/getNotification', [SocialController::class, 'getNotification']);

    Route::post('/Social/getEmployeeList', [SocialController::class, 'getEmployeeList']);

    Route::post('/Social/checkListDelegation', [SocialController::class, 'checkListDelegation']);
    Route::post('/Social/saveApproveCheckList', [SocialController::class, 'saveApproveCheckList']);
    Route::post('/Social/saveApprove', [SocialController::class, 'saveApprove']);
    #endregion

    #region MVL
    Route::get('/mvl/getMVLList', [
        MainvaluelistController::class,
        'getMVLList',
    ]);

    Route::get('/mvl/getMVLTypes', [
        MainvaluelistController::class,
        'getMVLTypes',
    ]);

    Route::get('/mvl/getParentMVL', [
        MainvaluelistController::class,
        'getParentMVL',
    ]);

    Route::post('/mvl/saveMVL', [MainvaluelistController::class, 'saveMVL']);

    Route::post('/mvl/editMVL', [MainvaluelistController::class, 'editMVL']);

    Route::post('/mvl/updateMVL', [
        MainvaluelistController::class,
        'updateMVL',
    ]);

    Route::post('/mvl/deleteMVL', [
        MainvaluelistController::class,
        'deleteMVL',
    ]);
    #endregion

    #region Admin

    #region User
    Route::post('/admin/getUsers', [AdminController::class, 'getUsers']);
    Route::post('/admin/getUserRole', [AdminController::class, 'getUserRole']);
    Route::post('/admin/assignRole', [AdminController::class, 'assignRole']);
    Route::post('/admin/editUser', [AdminController::class, 'editUser']);
    Route::post('/admin/updateUser', [AdminController::class, 'updateUser']);
    Route::post('/admin/resetPassword', [
        AdminController::class,
        'resetPassword',
    ]);
    Route::post('/admin/saveUser', [AdminController::class, 'saveUser']);
    Route::post('/admin/deleteUser', [AdminController::class, 'deleteUser']);
    Route::post('/admin/saveUserImage', [
        AdminController::class,
        'saveUserImage',
    ]);

    Route::post('/admin/maniUsers', [
        AdminController::class,
        'maniUsers',
    ]);

    Route::get('/admin/getGuardian', [
        AdminController::class,
        'getGuardian',
    ]);

    Route::post('/admin/importGuardian', [
        AdminController::class,
        'importGuardian',
    ]);

    Route::get('/admin/getStudents', [
        AdminController::class,
        'getStudents',
    ]);

    Route::post('/admin/getCampus', [AdminController::class, 'getCampus']);
    Route::post('/admin/assignCampus', [AdminController::class, 'assignCampus']);
    Route::post('/admin/getDepartment', [AdminController::class, 'getDepartment']);
    Route::post('/admin/assignDepartment', [AdminController::class, 'assignDepartment']);
    #endregion

    #region Permission
    Route::get('/admin/getpermissionlist', [
        AdminController::class,
        'getpermissionlist',
    ]);
    #endregion

    #region Roles
    Route::get('/admin/getrolelist', [AdminController::class, 'getrolelist']);
    Route::post('/admin/saverole', [AdminController::class, 'saverole']);
    Route::post('/admin/editrole', [AdminController::class, 'editrole']);
    Route::post('/admin/updaterole', [AdminController::class, 'updaterole']);
    Route::post('/admin/deleterole', [AdminController::class, 'deleterole']);
    Route::post('/admin/getrolepermission', [
        AdminController::class,
        'getrolepermission',
    ]);
    Route::post('/admin/assignPermission', [
        AdminController::class,
        'assignPermission',
    ]);

    #endregion

    #region User Profile
    Route::get('userprofile/getMyInfo', [UserProfileController::class, 'getMyInfo']);
    Route::get('userprofile/getMyAssignCampus', [UserProfileController::class, 'getMyAssignCampus']);
    Route::post('userprofile/assignDefualtCampus', [UserProfileController::class, 'assignDefualtCampus']);
    Route::get('userprofile/getMyAssignDepartment', [UserProfileController::class, 'getMyAssignDepartment']);
    Route::post('userprofile/assignDefualtDepartment', [UserProfileController::class, 'assignDefualtDepartment']);
    Route::post('userprofile/saveSignatureImage', [UserProfileController::class, 'saveSignatureImage']);
    Route::post('userprofile/saveUserImage', [UserProfileController::class, 'saveUserImage']);
    #endregion

    #region Exit Clearance
    Route::get('/ExitClearance/getExitClearanceCheckList', [ExitClearanceController::class, 'getExitClearanceCheckList']);
    Route::post('/ExitClearance/saveExitClearance', [ExitClearanceController::class, 'saveExitClearance']);
    Route::post('/ExitClearance/getExitClearanceList', [ExitClearanceController::class, 'getExitClearanceList']);
    Route::post('/ExitClearance/getExitClearanceAllList', [ExitClearanceController::class, 'getExitClearanceAllList']);
    Route::post('/ExitClearance/getExitClearanceRelateList', [ExitClearanceController::class, 'getExitClearanceRelateList']);
    Route::post('/ExitClearance/editExitClearance', [ExitClearanceController::class, 'editExitClearance']);
    Route::post('/ExitClearance/updateExitClearance', [ExitClearanceController::class, 'updateExitClearance']);
    Route::post('/ExitClearance/removeExitClearance', [ExitClearanceController::class, 'removeExitClearance']);
    Route::post('/ExitClearance/getUserImage', [ExitClearanceController::class, 'getUserImage']);
    Route::post('/ExitClearance/getExitEmployeeInfo', [ExitClearanceController::class, 'getExitEmployeeInfo']);
    Route::post('/ExitClearance/getUsers', [ExitClearanceController::class, 'getUsers']);
    Route::post('/ExitClearance/existUser', [ExitClearanceController::class, 'existUser']);
    Route::post('/ExitClearance/getCheckListRemark', [ExitClearanceController::class, 'getCheckListRemark']);
    Route::post('/ExitClearance/saveCheckListRemark', [ExitClearanceController::class, 'saveCheckListRemark']);
    #endregion

    #region push to other url
    Route::post('/pushexit/pushDeactivate', [PushExitController::class, 'pushDeactivate']);
    #endregion
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
