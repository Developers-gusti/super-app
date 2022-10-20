<?php

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

use Modules\Settings\Http\Controllers\PermissionController;
use Modules\Settings\Http\Controllers\RoleController;
use Modules\Settings\Http\Controllers\SettingsController;
use Modules\Settings\Http\Controllers\UserController;
Route::prefix('{locale}')->where(['locale' => '[a-zA-Z]{2}'])->group(function () {
Route::middleware(['auth:sanctum','prevent-back-history',config('jetstream.auth_session'),'verified'])->group(function () {
    Route::prefix('settings')->name('settings.')->group(function() {
        Route::get('/', [SettingsController::class,'index']);
        Route::get('/user',[UserController::class,'index'])->name('user');
        Route::get('/role',[RoleController::class,'index'])->name('role');
        Route::get('/permission',[PermissionController::class,'index'])->name('permission');
    });
});
});

