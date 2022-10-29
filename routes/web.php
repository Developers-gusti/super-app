<?php

use App\Http\Controllers\LocalizationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
Route::get('/', function () { return view('auth.login');});
Route::middleware(['auth:sanctum','prevent-back-history',config('jetstream.auth_session'),'verified'])->group(function () {
    Route::get('dashboard', function () {return view('dashboard');})->name('dashboard');
});
Route::get('language/{locale}', [LocalizationController::class,'lang'])->name('swich.lang');

