<?php
use Illuminate\Http\Request;
use App\Http\Requests\RegistertionRequest;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Auth\AuthController;




Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/verify_user_email', [AuthController::class, 'verifyUserEmail']);
    Route::post('/resend_token', [AuthController::class, 'ResendVerficationLink']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    // Route::get('/user-profile', [AuthController::class, 'userProfile']);    
    Route::get('/testid', [AuthController::class, 'testid']);  
});