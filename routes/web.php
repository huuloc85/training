<?php

use App\Http\Controllers\admin\DashBoardController;
use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\UserController;
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
//dashboad routes
Route::prefix('admin')->middleware(['isLoggedIn'])->group(function () {

    Route::get('index', [DashBoardController::class, 'index'])->name('admin.index');
    Route::get('change-password', [UserController::class, 'showViewChangePassword'])->name('show-change-password');
    Route::post('change-password', [UserController::class, 'changePassword'])->name('change-password');



    //user routes
    Route::prefix('user')->middleware(['RoleCheck'])->group(function () {
        Route::get('list', [UserController::class, 'list'])->name('user-list');
        Route::get('add', [UserController::class, 'add'])->name('user-add');
        Route::post('save', [UserController::class, 'save'])->name('user-save');
        Route::delete('delete/{id}', [UserController::class, 'delete'])->name('user-delete');
        Route::get('edit/{id}', [UserController::class, 'edit'])->name('user-edit');
        Route::post('update/{id}', [UserController::class, 'update'])->name('user-update');
        Route::get('changeInfor/{id}', [UserController::class, 'changeInfor'])->name('changeInfor');
        Route::post('updateInfor/{id}', [UserController::class, 'updateInfor'])->name('updateInfor');
    });
});
