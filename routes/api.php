<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaymentController;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function() {
    Route::post('login', [AuthController::class, 'login'])->withoutMiddleware('api');
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('me', [AuthController::class, 'me']);
});


Route::group([
    'middleware' => 'api',
    'prefix' => 'payment'
], function() {
    Route::post('/', [PaymentController::class, 'store']);
    Route::get('/{id}', [PaymentController::class, 'getById']);
});

