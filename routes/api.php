<?php

use App\Http\Controllers\Sanctum\ApiTokenController;
use App\Http\Controllers\Sanctum\CsrfCookieController;
use App\Http\Controllers\V1\UserController;
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

Route::group(['prefix' => 'sanctum', 'as' => 'sanctum.'], function () {
    Route::post('/token', [ApiTokenController::class, 'store'])->name('token.store');
    Route::get('/csrf-cookie', [CsrfCookieController::class, 'show'])->middleware('web')->name('csrf-cookie');
});

Route::group(['prefix' => 'v1', 'as' => 'v1.'], function () {

    Route::group(['as' => 'auth.'], base_path('routes/auth.php'));

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', [UserController::class, 'user'])->name('user');
    });
});
