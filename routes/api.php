<?php

use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\Ichi\Order\OrderController;
use App\Http\Controllers\Ichi\User\UserController;
use App\Http\Controllers\Support\LocationController;
use App\Http\Controllers\Warehouse\Car\CarbrandController;
use App\Http\Controllers\Warehouse\Car\CarmodelController;
use App\Http\Controllers\Warehouse\Part\InventoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', [LoginController::class, 'login'])->name('login');

Route::middleware(['auth:api'])->group(function () {

    Route::group(['prefix' => 'user'], function() {
        Route::post('/setfcm', [UserController::class, 'setfcm']);
    });

    Route::get('parts', [InventoryController::class, 'index']);

    Route::group(['prefix' => 'car'], function() {
        Route::get('/carbrand', [CarbrandController::class, 'index']);
        Route::get('/carmodel/{manuid}', [CarmodelController::class, 'index']);

    });

    Route::group(['prefix' => 'location'], function() {
        Route::get('/city', [LocationController::class, 'index']);
        Route::get('/sublocation/{id}', [LocationController::class, 'sublocation']);
    });

    Route::group(['prefix' => 'order'], function() {
        Route::get('/', [OrderController::class, 'index']);
        Route::get('/{id}', [OrderController::class, 'detail']);
        Route::post('/create', [OrderController::class, 'store']);
    });
});
