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
// Route::prefix('{locale}')->where(['locale' => '[a-zA-Z]{2}'])->group(function () {

// });

Route::middleware(['auth:sanctum','prevent-back-history',config('jetstream.auth_session'),'verified'])->group(function () {
    Route::prefix('settings')->name('settings.')->group(function() {
        Route::get('/', [SettingsController::class,'index']);
        /**
         * Menu User
         */
        Route::get('/user',[UserController::class,'index'])->name('user');
        Route::post('/user/store',[UserController::class,'store'])->name('user.store');
        Route::get('/user/edit/{id}',[UserController::class,'edit'])->name('user.edit');
        Route::delete('/user/delete/{id}',[UserController::class,'destroy'])->name('user.delete');
        /**
         * Menu Role
         */
        Route::get('/role',[RoleController::class,'index'])->name('role');
        Route::get('/role/create',[RoleController::class,'create'])->name('role.create');
        Route::post('/role/store',[RoleController::class,'store'])->name('role.store');
        Route::get('/role/edit/{id}',[RoleController::class,'edit'])->name('role.edit');
        Route::post('/role/update/{id}',[RoleController::class,'update'])->name('role.update');
        Route::delete('/role/delete/{id}',[RoleController::class,'destroy'])->name('role.delete');
        /**
         * Menu Permission
         */
        Route::get('/permission',[PermissionController::class,'index'])->name('permission');
        Route::post('/permission/store',[PermissionController::class,'store'])->name('permission.store');
        Route::get('/permission/edit/{id}',[PermissionController::class,'edit'])->name('permission.edit');
        Route::delete('/permission/delete/{id}',[PermissionController::class,'destroy'])->name('permission.delete');
        /**
         * Profile
         */
        Route::get('/profile',[UserController::class,'profile'])->name('profile');
        Route::post('/profile/update',[UserController::class,'updateProfile'])->name('profile.update');
        Route::post('/profile/change_password',[UserController::class,'selfChangePassword'])->name('profile.change.password');
    });
});
