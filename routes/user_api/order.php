<?php
use Illuminate\Http\Request;
use App\Http\Requests\RegistertionRequest;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Orders\OrderController;




Route::prefix('orders')->group(function () {
    Route::get('/', [OrderController::class, 'index']);
    Route::get('show/{id}', [OrderController::class, 'show']);
    Route::post('store', [OrderController::class, 'store']);
    Route::get('get_order_items/{id}', [OrderController::class, 'get_order_items']);
    Route::get('get_user_orders/{id}', [OrderController::class, 'get_user_orders']);
    Route::post('change_order_status/{id}', [OrderController::class, 'change_order_status']);
});
