<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MenuController;

Route::prefix('reservations')->group(function () {
    Route::post('/check-availability', [ReservationController::class, 'checkAvailability']);
    Route::post('/reserve-table', [ReservationController::class, 'reserveTable']);
});

Route::prefix('orders')->group(function () {
    Route::post('/order', [OrderController::class, 'order']);
    Route::post('/pay/{id}', [OrderController::class, 'pay']);
});

Route::get('/menu', [MenuController::class, 'listMenuItems']);
