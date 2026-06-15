<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\RoomController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Authentication routes
Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
});

// Protected routes
Route::middleware('api.auth')->group(function () {
    // Rooms routes
    Route::get('rooms', [RoomController::class, 'index']);
    Route::middleware('admin')->group(function () {
        Route::post('rooms', [RoomController::class, 'store']);
        Route::put('rooms/{room}', [RoomController::class, 'update']);
        Route::delete('rooms/{room}', [RoomController::class, 'destroy']);
    });

    // Bookings routes
    Route::get('bookings', [BookingController::class, 'index']);
    Route::post('bookings', [BookingController::class, 'store']);
    Route::delete('bookings/{booking}', [BookingController::class, 'destroy']);
});
