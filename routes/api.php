<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\{
    AuthController,
    CategoryController,
    ProductController,
    FilterController,
    CartController,
    CheckoutController
};
use App\Http\Controllers\{
    TestController
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


Route::get('/test', [TestController::class, 'test']);

Route::middleware(['api'])->group(function() {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);

    Route::group(['prefix'=>'categories'], function() {
        Route::get('/', [CategoryController::class, 'categories']);
    });

    Route::group(['prefix'=>'products'], function() {
        Route::get('/', [ProductController::class, 'products']);
        Route::get('/{product:slug}', [ProductController::class, 'show']);
    });

    Route::group(['prefix'=>'filters'], function() {
        Route::get('/', [FilterController::class, 'filters']);
    });

    //Route::middleware(['middleware' => 'auth.jwt'])->group(function() {
        Route::group(['prefix'=>'cart'], function() {
            Route::get('/', [CartController::class, 'carts']);
            Route::post('/add', [CartController::class, 'add_to_cart']);
            Route::post('/remove', [CartController::class, 'remove']);
        });

        Route::group(['prefix'=>'checkout'], function() {
            Route::post('/update-contact-information', [CheckoutController::class, 'update_contact_information']);
            Route::post('/update-shipping-address', [CheckoutController::class, 'shipping_address']);
            Route::get('/checkout', [CheckoutController::class, 'checkout']);
            Route::get('/countries', [CheckoutController::class, 'countries']);
        });

        
    //});
});