<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

Route::middleware([
    EnsureFrontendRequestsAreStateful::class,
    'auth:sanctum',
])->group(function () {
    Route::post('/purchase/premium', [PaymentController::class, 'subscribePremium']);
    Route::post('/purchase/boost', [PaymentController::class, 'purchaseBoost']);
});
