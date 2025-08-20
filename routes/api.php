<?php

use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\Ichi\Order\OrderController;
use App\Http\Controllers\Warehouse\Part\InventoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', [LoginController::class, 'login'])->name('login');

Route::middleware(['auth:api'])->group(function () {

    Route::get('parts', [InventoryController::class, 'index']);

    Route::group(['prefix' => 'order'], function() {
        Route::post('/create', [OrderController::class, 'store']);
    });
});
