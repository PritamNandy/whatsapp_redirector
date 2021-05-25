<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\DashboardController;
use \App\Http\Controllers\CampaignController;
use \App\Http\Controllers\GroupController;
use \App\Http\Controllers\ProfileController;
use \App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;

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

Route::get('/', [DashboardController::class, 'index']);

Route::post('/createUser', [UserController::class, 'registerUser']);

Route::get('/logout', [DashboardController::class, 'logout']);

Route::get('/c/{slug}',[CampaignController::class, 'visitCampaign']);

Route::get('/checkUniqueEmail/{email}', [DashboardController::class, 'checkUniqueEmail'])->name('checkUniqueEmail');
Route::get('/checkUniquePhone/{phone}', [DashboardController::class, 'checkUniquePhone'])->name('checkUniquePhone');

Route::get('/checkProfileUniqueEmail/{email}', [DashboardController::class, 'checkProfileUniqueEmail'])->name('checkProfileUniqueEmail');
Route::get('/checkProfileUniquePhone/{phone}', [DashboardController::class, 'checkProfileUniquePhone'])->name('checkProfileUniquePhone');

Route::get('/checkUserUniqueEmail/{email}/{id}', [UserController::class, 'checkUserUniqueEmail'])->name('checkUserUniqueEmail');

Route::group(['middleware' => 'auth'], function() {

    Route::get('/home', [DashboardController::class, 'index']);
    Route::get('/',  [DashboardController::class,'index']);
    Route::get('/addCampaign',  [CampaignController::class,'index']);
    Route::get('/checkCampaignSlug/{slug}', [CampaignController::class, 'checkCampaignSlug']);
    Route::get('/checkEditCampaignSlug/{slug}/{id}', [CampaignController::class, 'checkEditCampaignSlug']);
    Route::post('/createCampaign', [CampaignController::class, 'createCampaign']);
    Route::post('/updateCampaign', [CampaignController::class, 'updateCampaign']);
    Route::get('/editCampaign/{id}', [CampaignController::class, 'editCampaign']);
    Route::get('/deleteCampaign/{id}', [CampaignController::class, 'deleteCampaign']);
    Route::get('/campaign/{id}',[CampaignController::class, 'campaignById']);

    Route::get('/addGroup/{id}', [GroupController::class, 'index']);
    Route::post('/createGroup', [GroupController::class, 'createGroup']);
    Route::get('/editGroup/{id}', [GroupController::class, 'editGroup']);
    Route::get('/deleteGroup/{id}', [GroupController::class, 'deleteGroup']);

    Route::get('/c/{slug}', [CampaignController::class, 'goCampaign']);

    Route::get('/profile', [ProfileController::class, 'index']);
    Route::post('/updateProfile', [ProfileController::class, 'updateProfile']);

    Route::post('/updateSetting', [SettingsController::class, 'updateSettings']);

    Route::get('/getUser', [UserController::class, 'getUser'])->name('getUser');
    Route::post('/createUser', [UserController::class, 'createUser']);
    Route::post('/updateUser', [UserController::class, 'updateUser']);
    Route::get('/userDeactivate/{id}', [UserController::class, 'userDeactivate']);
    Route::get('/userActivate/{id}', [UserController::class, 'userActivate']);
    Route::get('/deleteUser/{id}', [UserController::class, 'deleteUser']);
    Route::get('/getUserById', [UserController::class, 'getUserById']);

    Route::group(['middleware' => 'role:admin', 'prefix' => 'admin', 'as' => 'admin.'], function() {
        Route::get('/',  [DashboardController::class,'index']);
        Route::get('/user', [UserController::class, 'index']);
        Route::get('/settings',  [SettingsController::class,'index']);
        Route::get('/addNewUser', [UserController::class, 'addUser']);
        Route::get('/editUser/{id}', [UserController::class, 'editUser']);
    });
});
