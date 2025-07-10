<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuotationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::post('/quotation', [QuotationController::class, 'store'])->name('api.v1.quotation.store');
});
