<?php
use Illuminate\Http\Request;
use App\Http\Requests\RegistertionRequest;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Products\ProductController;








Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('show/{id}', [ProductController::class, 'show']);
    Route::post('/store', [ProductController::class, 'store']);
    Route::post('/update/{id}', [ProductController::class, 'update']);
    Route::delete('/delete/{id}', [ProductController::class, 'destroy']);});

