<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\{
    AuthController,
    CategoryController,
    ProductController,
    FilterController
};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('test', function (Request $request) {
    return 'testing api';
});

Route::middleware(['api'])->group(function() {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);

    Route::group(['prefix'=>'categories'], function() {
        Route::get('/', [CategoryController::class, 'categories']);
    });

    Route::group(['prefix'=>'products'], function() {
        Route::get('/', [ProductController::class, 'products']);
    });

    Route::group(['prefix'=>'filters'], function() {
        Route::get('/', [FilterController::class, 'filters']);
    });
});