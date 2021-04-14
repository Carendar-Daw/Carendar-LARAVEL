<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SaloonController;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('saloon', [SaloonController::class, 'index']);
Route::get('saloon/{sal_id}', [SaloonController::class, 'show']);
Route::post('saloon', [SaloonController::class, 'create']);
Route::put('saloon/{sal_id}', [SaloonController::class, 'update']);

// This endpoint does not need authentication.
Route::get('/public', function (Request $request) {
    return response()->json(["message" => "Hello from a public endpoint! You don't need to be authenticated to see this."]);
});

// These endpoints require a valid access token.
Route::get('/private', function (Request $request) {
    return response()->json(["message" => "Hello from a private endpoint! You need to have a valid access token to see this."]);
})->middleware('jwt');
