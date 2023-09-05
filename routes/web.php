<?php

use App\Http\Controllers\admin\DashboadController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('admin/auth/login');
});
//admin dashboard
Route::prefix('admin')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('adminLogin');
    Route::post('login', [AuthController::class, 'login'])->name('adminLoginProcess');
    Route::get('logout', [AuthController::class, 'logout'])->name('adminLogout');
});
//dashboard routes
Route::prefix('admin')->middleware(['isLoggedIn'])->group(function () {
    Route::get('index', [DashboadController::class, 'index'])->name('admin.index');
});
