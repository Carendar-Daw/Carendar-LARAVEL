<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\StockController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SaloonController;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'jwt:api'], function () {
    // Saloon Endpoints
    Route::get('saloon', [SaloonController::class, 'index']);
    Route::get('saloon/{sal_id}', [SaloonController::class, 'show']);
    Route::post('saloon', [SaloonController::class, 'create']);
    Route::put('saloon/{sal_id}', [SaloonController::class, 'update']);

    // Customer Endpoints
    Route::get('customer', [CustomerController::class, 'index']);
    Route::get('customer/{cus_id}', [CustomerController::class, 'show']);
    Route::post('customer', [CustomerController::class, 'create']);
    Route::put('customer/{cus_id}', [CustomerController::class, 'update']);

    // Appointment Endpoints
    Route::get('appointment/saloon/{sal_id}', [AppointmentController::class, 'indexSaloon']);
    Route::get('appointment/customer/{cus_id}', [AppointmentController::class, 'indexCustomer']);
    Route::get('appointment/{app_id}', [AppointmentController::class, 'show']);
    Route::post('appointment', [AppointmentController::class, 'create']);
    Route::put('appointment/{app_id}', [AppointmentController::class, 'update']);
    
    // Services Endpoints
    Route::get('services', [ServicesController::class, 'index']);
    Route::get('services/{sal_id}', [ServicesController::class, 'indexService']);
    Route::post('services', [ServicesController::class, 'create']);
    Route::put('services/{sal_id}', [ServicesController::class, 'update']);
    Route::delete('services/{sal_id}', [ServicesController::class, 'destroy']);

    // Stocks Endpoints
    Route::get('stock', [StockController::class, 'index']);
    Route::get('stock/{sto_id}', [StockController::class, 'indexStock']);
    Route::post('stock', [StockController::class, 'create']);
    Route::put('stock/{sto_id}', [StockController::class, 'update']);
    Route::delete('stock/{sto_id}', [StockController::class, 'destroy']);
});

// This endpoint does not need authentication.
Route::get('public', function (Request $request) {
    return response()->json(["message" => "Hello from a public endpoint! You don't need to be authenticated to see this."]);
});

// These endpoints require a valid access token.
Route::get('private', function (Request $request) {
    return response()->json(["message" => "Hello from a private endpoint! You need to have a valid access token to see this."]);
})->middleware('jwt');
