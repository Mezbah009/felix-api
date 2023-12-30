<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ColorController;
use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\ProductStockController;
use App\Http\Controllers\API\UnitController;
use App\Http\Controllers\Api\DashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


// Registration and login routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Logout route (you can protect this route with middleware if needed)
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');


// unit route
Route::get('/units', [UnitController::class, 'index']);
Route::get('/units/{id}', [UnitController::class, 'show']);
Route::post('/units', [UnitController::class, 'store']);
Route::put('/units/{id}', [UnitController::class, 'update']);
Route::delete('/units/{id}', [UnitController::class, 'destroy']);


//Color Route
Route::apiResource('colors', ColorController::class);

// Route::get('/colors', [ColorController::class, 'index']);
// Route::get('/colors/{id}', [ColorController::class, 'show']);
// Route::post('/colors', [ColorController::class, 'store']);
// Route::put('/colors/{id}', [ColorController::class, 'update']);
// Route::delete('/colors/{id}', [ColorController::class, 'destroy']);


// Product routes
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::post('/products', [ProductController::class, 'store']);
Route::put('/products/{id}', [ProductController::class, 'update']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);


// Customer routes
Route::get('/customers', [CustomerController::class, 'index']);
Route::get('/customers/{id}', [CustomerController::class, 'show']);
Route::post('/customers', [CustomerController::class, 'store']);
Route::put('/customers/{id}', [CustomerController::class, 'update']);
Route::delete('/customers/{id}', [CustomerController::class, 'destroy']);

// New route for customer search by mobile
Route::get('/customer/search', [CustomerController::class, 'searchByMobile']);


// Order routes
// Route::get('/orders', [OrderController::class, 'index']);
// Route::get('/orders/{id}', [OrderController::class, 'show']);
// Route::post('/orders', [OrderController::class, 'store']);
// Route::put('/orders/{id}', [OrderController::class, 'update']);
// Route::delete('/orders/{id}', [OrderController::class, 'destroy']);

// New route for getting order history by date
Route::get('/order-history-by-date', [OrderController::class, 'getOrderHistoryByDate']);
Route::post('/order/history-by-date', [OrderController::class, 'getOrderHistoryByDate']);

// New routes for individual updates
Route::put('/orders/{id}/update-payment-status', [OrderController::class, 'updatePaymentStatus']);
Route::put('/orders/{id}/update-status', [OrderController::class, 'updateStatus']);


// Route for creating product stock
Route::get('/product-stocks', [ProductStockController::class, 'index']);
Route::get('/product-stocks/{id}', [ProductStockController::class, 'show']);
Route::post('/product-stocks', [ProductStockController::class, 'store']);




// Order routes
Route::get('/orders', [OrderController::class, 'index']);
Route::get('/orders/{id}', [OrderController::class, 'show']);
Route::post('/orders', [OrderController::class, 'store']);
Route::put('/orders/{id}', [OrderController::class, 'update']);
Route::delete('/orders/{id}', [OrderController::class, 'destroy']);

// Additional routes for your specific requirements

// For example, a route to search orders by customer ID
Route::get('/order/search', [OrderController::class, 'searchByCustomerId']);




Route::get('/dashboard', [DashboardController::class, 'getDashboardData']);


Route::get('/order/{orderId}/details', [OrderController::class, 'getOrderDetails']);


//Route::get('/orders', [OrderController::class, 'getAllOrders']);


