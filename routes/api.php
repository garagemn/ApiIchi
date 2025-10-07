<?php

use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\Ichi\Basket\BasketController;
use App\Http\Controllers\Ichi\Order\OrderController;
use App\Http\Controllers\Ichi\User\NotificationController;
use App\Http\Controllers\Ichi\User\UserController;
use App\Http\Controllers\Support\LocationController;
use App\Http\Controllers\Warehouse\Car\CarbrandController;
use App\Http\Controllers\Warehouse\Car\CarengineController;
use App\Http\Controllers\Warehouse\Car\CarmodelController;
use App\Http\Controllers\Warehouse\Part\CategoryController;
use App\Http\Controllers\Warehouse\Part\InventoryController;
use App\Http\Controllers\Warehouse\Part\PartbrandController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', [LoginController::class, 'login'])->name('login');

Route::middleware(['auth:api'])->group(function () {

    Route::group(['prefix' => 'user'], function() {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/childs', [UserController::class, 'childs']);
        Route::post('/setfcm', [UserController::class, 'setfcm']);

        Route::group(['prefix' => 'notification'], function () {
            Route::get('/', [NotificationController::class, 'index']);
        });
    });

    Route::get('/category', [CategoryController::class, 'index']);
    Route::get('/partbrands', [PartbrandController::class, 'index']);
    Route::get('/partbrand/{id}', [PartbrandController::class, 'detail']);
    Route::get('parts', [InventoryController::class, 'index']);

    Route::get('/add', [BasketController::class, 'add']);

    Route::group(['prefix' => 'car'], function() {
        Route::get('/carbrand', [CarbrandController::class, 'index']);
        Route::get('/carmodel/{manuid}', [CarmodelController::class, 'index']);
        Route::get('/carengine/{manuid}/{modelid}', [CarengineController::class, 'index']);
    });

    Route::group(['prefix' => 'location'], function() {
        Route::get('/city', [LocationController::class, 'index']);
        Route::get('/sublocation/{id}', [LocationController::class, 'sublocation']);
    });

    Route::group(['prefix' => 'order'], function() {
        Route::get('/pickupbranch', [OrderController::class, 'pickupbranch'])->name('order.pickupbranches');
        Route::get('/', [OrderController::class, 'index'])->name('order.index');
        Route::get('/{id}', [OrderController::class, 'detail'])->name('order.detail');
        Route::post('/create', [OrderController::class, 'store'])->name('order.store');
    });
    
});
