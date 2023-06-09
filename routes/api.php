<?php

use App\Http\Controllers\v1\CustomerController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::get('test', [CustomerController::class, 'test']);
    Route::post('create-customer', [CustomerController::class, 'createCustomer']);
    Route::get('get-all-customers', [CustomerController::class, 'getAllCustomers']);
    Route::get('get-customer/{customerId}', [CustomerController::class, 'getCustomer']);

    Route::put('update-customer/{customerId}', [CustomerController::class, 'updateCustomer']);
    Route::post('delete-customer/{customerId}', [CustomerController::class, 'deleteCustomer']);



});
