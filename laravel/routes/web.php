<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SampahController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'input'])->name('input');

Route::group(['middleware' => ['auth'], 'prefix' => 'admin.', 'as' => 'admin.'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/rekap', [DashboardController::class, 'rekap'])->name('rekap');
    Route::get('/export/{jenis}', [DashboardController::class, 'export'])->name('export');
    Route::resource('/sampah', SampahController::class);
    Route::resource('/user', UserController::class);
    Route::resource('/role', RoleController::class);
});
