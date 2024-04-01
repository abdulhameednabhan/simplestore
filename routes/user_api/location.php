<?php
use Illuminate\Http\Request;
use App\Http\Requests\RegistertionRequest;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\locations\LocationController;



Route::prefix('locations')->group(function () {
    
    Route::post('/store', [LocationController::class, 'store']);
    Route::post('/update/{id}', [LocationController::class, 'update']);
    Route::delete('/delete/{id}', [LocationController::class, 'destroy']);});



