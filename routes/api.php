<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\CashRegisterController;
use App\Http\Controllers\ToursController;
use App\Http\Controllers\SaloonController;

use App\Http\Controllers\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'jwt:api'], function () {
    // Saloon Endpoints
    Route::get('saloon/{id_auth}', [SaloonController::class, 'index']);
    Route::get('saloon', [SaloonController::class, 'show']);
    Route::post('saloon', [SaloonController::class, 'create']);
    Route::put('saloon', [SaloonController::class, 'update']);

    // Customer Endpoints
    Route::get('customer', [CustomerController::class, 'index']);
    Route::get('customer/{cus_id}', [CustomerController::class, 'show']);
    Route::post('customer', [CustomerController::class, 'create']);
    Route::put('customer/{cus_id}', [CustomerController::class, 'update']);
    Route::delete('customer/{cus_id}', [CustomerController::class, 'destroy']);

    // Appointment Endpoints
    Route::get('appointment/saloon', [AppointmentController::class, 'index']);
    Route::get('appointment/date', [AppointmentController::class, 'getCustomerByAppointmentsByDate']);
    Route::get('appointment/customer/{cus_id}', [AppointmentController::class, 'indexAppointmentByCustomer']);
    Route::get('appointment/cash', [AppointmentController::class, 'indexAppointmentCash']);
    Route::post('appointment', [AppointmentController::class, 'create']);
    Route::put('appointment/{app_id}', [AppointmentController::class, 'update']);
    Route::delete('appointment/{app_id}', [AppointmentController::class, 'delete']);

    // Services Endpoints
    Route::get('services', [ServicesController::class, 'index']);
    Route::get('services/{app_id}', [ServicesController::class, 'listServiceByAppointment']);
    // Route::get('services/{app_id}', [AppointmentController::class, 'listServiceByAppointment']);
    Route::post('services', [ServicesController::class, 'create']);
    Route::put('services/{ser_id}', [ServicesController::class, 'update']);
    Route::delete('services/{ser_id}', [ServicesController::class, 'destroy']);

    // Stocks Endpoints
    Route::get('stock', [StockController::class, 'index']);
    Route::post('stock', [StockController::class, 'create']);
    Route::put('stock/{sto_id}', [StockController::class, 'update']);
    Route::delete('stock/{sto_id}', [StockController::class, 'destroy']);
    /*Route::get('stock/{sto_id}', [StockController::class, 'listStockByServicesByAppointment']);*/

    //Language Endpoints
    Route::get('language', [LanguageController::class, 'index']);
    Route::get('language/{sal_id}', [LanguageController::class, 'indexLanguage']);
    Route::post('language', [LanguageController::class, 'create']);
    Route::put('language', [LanguageController::class, 'update']);
    Route::delete('language/{sal_id}', [LanguageController::class, 'destroy']);

    //CashRegister Endpoints
    Route::get('cashregister', [CashRegisterController::class, 'index']);
    Route::get('cashregister/{sal_id}', [CashRegisterController::class, 'IndexCashRegister']);
    Route::post('cashregister', [CashRegisterController::class, 'create']);
    Route::put('cashregister', [CashRegisterController::class, 'update']);
    Route::delete('cashregister/{sal_id}', [CashRegisterController::class, 'destroy']);

    //Tours Endpoints
    Route::get('tours', [ToursController::class, 'index']);
    Route::post('tours', [ToursController::class, 'create']);
    Route::put('tours', [ToursController::class, 'update']);
    Route::delete('tours', [ToursController::class, 'destroy']);

    //Statistics Endpoints
    Route::post('statistics', [SaloonController::class, 'statistics']);

    //Transactions Endpoints
    Route::get('transaction', [TransactionController::class, 'list']);
    Route::post('transaction', [TransactionController::class, 'create']);
    Route::put('transaction/{tra_id}', [TransactionController::class, 'update']);
    Route::delete('transaction/{tra_id}', [TransactionController::class, 'delete']);
});



// This endpoint does not need authentication.
Route::get('public', function (Request $request) {
    return response()->json(["message" => "Hello from a public endpoint! You don't need to be authenticated to see this."]);
});

// These endpoints require a valid access token.
Route::get('private', function (Request $request) {
    return response()->json(["message" => "Hello from a private endpoint! You need to have a valid access token to see this."]);
})->middleware('jwt');
