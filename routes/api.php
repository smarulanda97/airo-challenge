<?php

use App\Http\Controllers\QuotationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::post('/quotation', [QuotationController::class, 'store'])->name('api.v1.quotation.store');
});
