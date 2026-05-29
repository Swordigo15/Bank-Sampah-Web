<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SampahController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/template', function(){ return view('index'); })->name('template');
Route::get('/template/login', function(){ return view('auth.login'); })->name('template.login');
Route::get('/', [DashboardController::class, 'input'])->name('input');
Route::post('/input', [DashboardController::class, 'store'])->name('input.store');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login.show');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register.show');
Route::post('/register', [AuthController::class, 'register'])->name('register');
// Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
// Route::post('/update-password/{id}', function() {})->name('password.update');

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
// Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/riwayat', [DashboardController::class, 'riwayat'])->name('riwayat');
    Route::get('/rekap', [DashboardController::class, 'rekap'])->name('rekap');
    Route::get('/export/{jenis}', [DashboardController::class, 'export'])->name('export');
    Route::resource('/sampah', SampahController::class);
    Route::resource('/user', UserController::class);
    Route::resource('/role', RoleController::class);
});
