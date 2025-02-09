<?php

use App\Http\Controllers\Api\PasienController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DrugController;

/**
 * route "/register"
 * @method "POST"
 */
Route::post('/register', App\Http\Controllers\Api\RegisterController::class)->name('register');

/**
 * route "/login"
 * @method "POST"
 */
Route::post('/v1/auth', App\Http\Controllers\Api\LoginController::class);

/**
 * route "/user"
 * @method "GET"
 */
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('/pasien', PasienController::class)->middleware('auth:api');
Route::resource('/v1/auth/medicines', DrugController::class)->middleware('auth:api');
Route::get('/v1/auth/medicines/{id}/{request}',[DrugController::class, 'hrg'])->middleware('auth:api');