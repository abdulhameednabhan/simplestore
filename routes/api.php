<?php
use Illuminate\Http\Request;
use App\Http\Requests\RegistertionRequest;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\OrderController;

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/verify_user_email', [AuthController::class, 'verifyUserEmail']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    // Route::get('/user-profile', [AuthController::class, 'userProfile']);    
    // Route::get('/testid', [AuthController::class, 'testid']);  
});


Route::prefix('brands')->group(function () {
    Route::get('/', [BrandController::class, 'index']);
    Route::post('/store', [BrandController::class, 'store']);
    Route::get('/show/{id}', [BrandController::class, 'show']);
    Route::put('/update/{id}', [BrandController::class, 'update']);
    Route::delete('/delete/{id}', [BrandController::class, 'destroy']);
});


Route::prefix('categories')->group(function () {
Route::get('/', [CategoryController::class, 'index']);
Route::get('/show/{id}', [CategoryController::class, 'show']);
Route::post('/store', [CategoryController::class, 'store']);
Route::post('/update/{id}', [CategoryController::class, 'update']);
Route::delete('/delete/{id}', [CategoryController::class, 'destroy']);});


Route::prefix('locations')->group(function () {
    
    Route::post('/store', [LocationController::class, 'store']);
    Route::post('/update/{id}', [LocationController::class, 'update']);
    Route::delete('/delete/{id}', [LocationController::class, 'destroy']);});



Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('show/{id}', [ProductController::class, 'show']);
    Route::post('/store', [ProductController::class, 'store']);
    Route::post('/update/{id}', [ProductController::class, 'update']);
    Route::delete('/delete/{id}', [ProductController::class, 'destroy']);});



    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'index']);
        Route::get('show/{id}', [OrderController::class, 'show']);
        Route::post('store', [OrderController::class, 'store']);
        Route::get('get_order_items/{id}', [OrderController::class, 'get_order_items']);
        Route::get('get_user_orders/{id}', [OrderController::class, 'get_user_orders']);
        Route::post('change_order_status/{id}', [OrderController::class, 'change_order_status']);
    });