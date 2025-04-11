<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExitClearanceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AbbreviationController;
use App\Http\Controllers\MainvaluelistController;
use App\Http\Controllers\PushExitController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\StoreController;

use App\Http\Controllers\CampusController;
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
    Route::get('/dashboard/index', [UserProfileController::class, 'dashboard']);
    Route::get('/userprofile/Index', [UserProfileController::class, 'index']);
    #endregion

    #region exit clearance
    Route::get('/exitClearance/index', [ExitClearanceController::class, 'index']);
    Route::post('/exit_clearance/getExitClearancePDF', [ExitClearanceController::class, 'getExitClearancePDF']);
    Route::post('/ExitClearance/viewUserPhoto', [ExitClearanceController::class, 'viewUserPhoto']);
    Route::Post('/social/getCheckerForm', [SocialController::class, 'getCheckerForm']);
    Route::Post('/social/getApprovalForm', [SocialController::class, 'getApprovalForm']);
    #endregion

    #Contract

    Route::get('/customers/index', [CustomerController::class, 'index'])->name('customer.index');
    Route::get('/customers/data', [CustomerController::class, 'data'])->name('customer.data');
    Route::get('/customer/create', [CustomerController::class, 'create'])->name('customer.create');
    Route::post('/customer', [CustomerController::class, 'store'])->name('customer.store');
    Route::get('/customer/{id}/edit', [CustomerController::class, 'edit'])->name('customer.edit');
    Route::put('/customer/{id}', [CustomerController::class, 'update'])->name('customer.update');
    Route::delete('/destroyCustomer/{id}', [CustomerController::class, 'destroy'])->name('customer.destroy');    #End Contract


    Route::get('/stores/index', [StoreController::class, 'index'])->name('store.index');
    Route::get('/stores/data', [StoreController::class, 'data'])->name('store.data');
    Route::get('/stores/create', [StoreController::class, 'create'])->name('store.create');
    Route::post('/store', [StoreController::class, 'store'])->name('store.store');
    Route::get('/store/{id}/edit', [StoreController::class, 'edit'])->name('store.edit');
    Route::put('/store/{id}', [StoreController::class, 'update'])->name('store.update');
    Route::delete('/destroyStore/{id}/destroy', [StoreController::class, 'destroy'])->name('store.destroy');    #End Contract

    // Abbreviation


    Route::get('/abbreviations/index    ', [AbbreviationController::class, 'index'])->name('abbreviations.index');
    Route::get('/abbreviations/data', [AbbreviationController::class, 'data'])->name('abbreviations.data');
    Route::get('/abbreviations/create', [AbbreviationController::class, 'create'])->name('abbreviations.create');
    Route::post('/abbreviations', [AbbreviationController::class, 'store'])->name('abbreviations.store');
    Route::get('/abbreviations/{id}/edit', [AbbreviationController::class, 'edit'])->name('abbreviations.edit');
    Route::put('/abbreviations/{id}', [AbbreviationController::class, 'update'])->name('abbreviations.update');
    Route::delete('/destroyabbreviations/{id}', [AbbreviationController::class, 'destroy'])->name('abbreviations.destroy');    #End Contract
    
    
    // End Abbreviation

    // Route::get('/abbreviation/{abbreviation}', [AbbreviationController::class, 'index'])->name('abbreviation.index');

    // Route::get('/abbreviation/show/{abbreviation}', [AbbreviationController::class, 'show'])->name('abbreviation.show');

    #region push to other url
    Route::get('/pushexit/index', [PushExitController::class, 'index']);
    #endregion



    Route::get('/locations/data', [LocationController::class, 'getLocationsData']);
    Route::get('/locations/index', [LocationController::class, 'index']);

    Route::post('/location', [LocationController::class, 'store']);
    Route::get('/location/{id}/edit', [LocationController::class, 'edit']);
    Route::put('/location/{id}', [LocationController::class, 'update']);
    Route::delete('/destroyLocation/{id}', [LocationController::class, 'destroy']);




    Route::get('/campuses/index', [CampusController::class, 'index']);
    Route::get('/campuses/data', [CampusController::class, 'getCampusesData']);

    Route::post('/campus', [CampusController::class, 'store']);
    Route::get('/campus/{id}/edit', [CampusController::class, 'edit']);
    Route::put('/campus/{id}', [CampusController::class, 'update']);
    Route::delete('/destroyCampus/{id}', [CampusController::class, 'destroy']);

});
