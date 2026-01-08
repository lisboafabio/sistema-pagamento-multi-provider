<?php

use App\Http\Controllers\CheckoutWebhookController;

Route::prefix('v1')->group(function(){
    Route::post('checkout', [CheckoutWebhookController::class, 'handle']);
});



