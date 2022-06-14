<?php

use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PosController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SalaryController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    Route::post('register', [AuthController::class, 'register']);
});

Route::apiResource('/employees', EmployeeController::class);
Route::apiResource('/suppliers', SupplierController::class);
Route::apiResource('/categories', CategoryController::class);
Route::apiResource('/products', ProductController::class);
Route::apiResource('/expenses', ExpenseController::class);
Route::apiResource('/customers', CustomerController::class);

Route::post('/salary/paid/{id}', [SalaryController::class, 'paid']);
Route::get('/salary', [SalaryController::class, 'allSalary']);
Route::get('/salary/view/{id}', [SalaryController::class, 'viewSalary']);
Route::get('/salary/edit/{id}', [SalaryController::class, 'editSalary']);
Route::post('/salary/update/{id}', [SalaryController::class, 'updateSalary']);

Route::post('/stock/update/{id}', [ProductController::class, 'updateStock']);
Route::get('/products/get/{id}', [PosController::class, 'getProducts']);

Route::get('/cart/add/{id}', [CartController::class, 'addToCart']);
Route::get('/cart/products', [CartController::class, 'cartProducts']);
Route::get('/cart/remove/{id}', [CartController::class, 'removeFromCart']);
Route::get('/cart/increment/{id}', [CartController::class, 'incrementCart']);
Route::get('/cart/decrement/{id}', [CartController::class, 'decrementCart']);

Route::get('/vats', [CartController::class, 'vats']);

Route::post('/order/done', [PosController::class, 'orderDone']);

Route::get('/orders', [OrderController::class, 'todayOrders']);
Route::get('/order/details/{id}', [OrderController::class, 'orderDetails']);
Route::get('/order/details/all/{id}', [OrderController::class, 'orderDetailsAll']);
Route::post('/order/search', [PosController::class, 'searchOrder']);
