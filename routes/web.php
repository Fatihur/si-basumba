<?php

use App\Http\Controllers\Admin\AbhController;
use App\Http\Controllers\Admin\AlurPelayananController;
use App\Http\Controllers\Admin\AsalPermintaanController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InstansiKepolisianController;
use App\Http\Controllers\Admin\JenisLitmasController;
use App\Http\Controllers\Admin\KlienController;
use App\Http\Controllers\Admin\LitmasController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\PetugasController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WajibLaporController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Auth Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Wajib Lapor
    Route::get('/wajib-lapor', [WajibLaporController::class, 'index'])->name('wajib-lapor.index');
    Route::get('/wajib-lapor/{wajibLapor}', [WajibLaporController::class, 'show'])->name('wajib-lapor.show');
    Route::post('/wajib-lapor/{wajibLapor}/verify', [WajibLaporController::class, 'verify'])->name('wajib-lapor.verify');
    Route::get('/wajib-lapor-export', [WajibLaporController::class, 'export'])->name('wajib-lapor.export');

    // LITMAS
    Route::get('/litmas', [LitmasController::class, 'index'])->name('litmas.index');
    Route::get('/litmas/{litma}', [LitmasController::class, 'show'])->name('litmas.show');
    Route::post('/litmas/{litma}/status', [LitmasController::class, 'updateStatus'])->name('litmas.update-status');
    Route::get('/litmas-file/{file}/download', [LitmasController::class, 'downloadFile'])->name('litmas.download-file');

    // ABH
    Route::get('/abh', [AbhController::class, 'index'])->name('abh.index');
    Route::get('/abh/{abh}', [AbhController::class, 'show'])->name('abh.show');
    Route::post('/abh/{abh}/status', [AbhController::class, 'updateStatus'])->name('abh.update-status');
    Route::post('/abh/{abh}/upload', [AbhController::class, 'uploadFile'])->name('abh.upload');

    // Klien
    Route::resource('klien', KlienController::class);

    // Petugas
    Route::resource('petugas', PetugasController::class);

    // Master Data
    Route::resource('asal-permintaan', AsalPermintaanController::class)->except(['create', 'show', 'edit']);
    Route::resource('jenis-litmas', JenisLitmasController::class)->except(['create', 'show', 'edit']);
    Route::resource('instansi-kepolisian', InstansiKepolisianController::class)->except(['create', 'show', 'edit']);
    Route::resource('alur-pelayanan', AlurPelayananController::class)->except(['create', 'show', 'edit']);

    // Users (Admin only)
    Route::resource('users', UserController::class)->except(['show'])->middleware('can:admin');

    // Settings (Admin only)
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index')->middleware('can:admin');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update')->middleware('can:admin');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/unread', [NotificationController::class, 'getUnread'])->name('notifications.unread');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
});
