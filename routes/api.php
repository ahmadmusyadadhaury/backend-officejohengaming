<?php

use App\Http\Controllers\Api\AssetApiController;
use App\Http\Controllers\Api\AsetDayaApiController;
use App\Http\Controllers\Api\AsetRukoApiController;
use App\Http\Controllers\Api\AsetTimApiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\DigitalAssetApiController;
use App\Http\Controllers\Api\VehicleApiController;
use App\Http\Controllers\Api\SimCardApiController;
use App\Http\Controllers\Api\PeralatanKantorApiController;
use App\Http\Controllers\Api\PaymentApprovalApiController;
use App\Http\Controllers\Api\PembayaranApiController;
use App\Http\Controllers\Api\RoomController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('api.auth');

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
});

Route::middleware('api.auth')->group(function () {

    Route::get('rooms', [RoomController::class, 'index']);
    Route::middleware('admin')->group(function () {
        Route::post('rooms', [RoomController::class, 'store']);
        Route::put('rooms/{room}', [RoomController::class, 'update']);
        Route::delete('rooms/{room}', [RoomController::class, 'destroy']);
    });

    Route::get('bookings', [BookingController::class, 'index']);
    Route::post('bookings', [BookingController::class, 'store']);
    Route::delete('bookings/{booking}', [BookingController::class, 'destroy']);

    Route::apiResource('assets', AssetApiController::class)->parameters(['assets' => 'asset']);
    Route::apiResource('aset-ruko', AsetRukoApiController::class)->parameters(['aset_ruko' => 'ruko']);
    Route::apiResource('aset-daya', AsetDayaApiController::class)->parameters(['aset_daya' => 'asetDaya']);
    Route::apiResource('aset-tim', AsetTimApiController::class)->parameters(['aset_tim' => 'asetTim']);
    Route::apiResource('digital-assets', DigitalAssetApiController::class)->parameters(['digital_assets' => 'digitalAsset']);
    Route::get('vehicles', [VehicleApiController::class, 'index']);
    Route::get('sim-cards', [SimCardApiController::class, 'index']);
    Route::get('peralatan-kantor', [PeralatanKantorApiController::class, 'index']);

    Route::prefix('pembayaran')->group(function () {
        Route::get('/', [PembayaranApiController::class, 'index']);
        Route::post('/', [PembayaranApiController::class, 'store']);
        Route::put('{id}', [PembayaranApiController::class, 'update']);
        Route::delete('{id}', [PembayaranApiController::class, 'destroy']);
        Route::post('ipl-bulk', [PembayaranApiController::class, 'bulkIpl']);
        Route::post('ipl-ruko-bulk', [PembayaranApiController::class, 'storeBulkIplRuko']);
        Route::post('token-reading', [PembayaranApiController::class, 'storeTokenReading']);
        Route::delete('token-reading/{id}', [PembayaranApiController::class, 'destroyTokenReading']);
        Route::post('token-topup', [PembayaranApiController::class, 'storeTokenPayment']);
        Route::delete('token-topup/{id}', [PembayaranApiController::class, 'destroyTokenPayment']);
        Route::post('internet-usage', [PembayaranApiController::class, 'storeInternetUsage']);
        Route::delete('internet-usage/{id}', [PembayaranApiController::class, 'destroyInternetUsage']);
    });

    Route::prefix('payment-approvals')->group(function () {
        Route::get('/', [PaymentApprovalApiController::class, 'index']);
        Route::post('{id}/approve', [PaymentApprovalApiController::class, 'approve']);
        Route::post('{id}/reject', [PaymentApprovalApiController::class, 'reject']);
    });
});
