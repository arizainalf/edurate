<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;

Route::match(['get', 'post'], '/', [AuthController::class, 'login'])->name('login');
Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->middleware('guest')->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->middleware('guest')->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'resetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('jabatan', JabatanController::class)->names('jabatan');

    Route::match(['get', 'put'], 'profil', [ProfileController::class, 'index'])->name('profil');
    Route::put('profil/password', [ProfileController::class, 'updatePassword'])->name('profil.password');
});
