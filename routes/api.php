<?php

use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth.token')->group(function () {
    Route::post('/order', [OrderController::class, 'create']);
    Route::get('/orders/pending', [OrderController::class, 'listPendingOrders']);
    Route::post('/order/follow', [OrderController::class, 'followOrder']);
});
