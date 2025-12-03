<?php

use App\Http\Controllers\Api\AbhController;
use App\Http\Controllers\Api\AlurPelayananController;
use App\Http\Controllers\Api\LitmasController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\WajibLaporController;
use Illuminate\Support\Facades\Route;

// Mobile App API
Route::prefix('v1')->group(function () {
    // Wajib Lapor
    Route::get('/petugas', [WajibLaporController::class, 'getPetugas']);
    Route::post('/wajib-lapor', [WajibLaporController::class, 'store']);
    Route::post('/wajib-lapor/check-status', [WajibLaporController::class, 'checkStatus']);

    // LITMAS
    Route::get('/litmas/master-data', [LitmasController::class, 'getMasterData']);
    Route::post('/litmas', [LitmasController::class, 'store']);

    // ABH
    Route::get('/instansi-kepolisian', [AbhController::class, 'getInstansi']);
    Route::post('/abh', [AbhController::class, 'store']);

    // Alur Pelayanan
    Route::get('/alur-pelayanan', [AlurPelayananController::class, 'index']);

    // Settings
    Route::get('/settings/whatsapp', [SettingController::class, 'getWhatsapp']);
});
