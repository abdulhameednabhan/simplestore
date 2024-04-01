<?php
use Illuminate\Http\Request;
use App\Http\Requests\RegistertionRequest;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Categs\CategoryController;



Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::get('/show/{id}', [CategoryController::class, 'show']);
    Route::post('/store', [CategoryController::class, 'store']);
    Route::post('/update/{id}', [CategoryController::class, 'update']);
    Route::delete('/delete/{id}', [CategoryController::class, 'destroy']);});
    