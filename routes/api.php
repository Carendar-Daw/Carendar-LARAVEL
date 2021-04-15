<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\CustomerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SaloonController;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

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

// This endpoint does not need authentication.
Route::get('/public', function (Request $request) {
    return response()->json(["message" => "Hello from a public endpoint! You don't need to be authenticated to see this."]);
});

// These endpoints require a valid access token.
Route::get('/private', function (Request $request) {
    return response()->json(["message" => "Hello from a private endpoint! You need to have a valid access token to see this."]);
})->middleware('jwt');
