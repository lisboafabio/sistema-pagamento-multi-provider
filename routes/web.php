<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return [
        'status' => 'ok',
        'timestamp' => Carbon::now(),
    ];
});
