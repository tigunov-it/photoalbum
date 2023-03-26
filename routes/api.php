<?php

use App\Http\Controllers\Sanctum\ApiTokenController;
use App\Http\Controllers\Sanctum\CsrfCookieController;
use App\Http\Controllers\V1\AlbumController;
use App\Http\Controllers\V1\AlbumPostController;
use App\Http\Controllers\V1\PostController;
use App\Http\Controllers\V1\ProfileController;
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

Route::group([], base_path('routes/auth.php'));

Route::group(['prefix' => 'sanctum', 'as' => 'sanctum.'], function () {
    Route::post('/token', [ApiTokenController::class, 'store'])->name('token.store');
    Route::get('/csrf-cookie', [CsrfCookieController::class, 'show'])->middleware('web')->name('csrf-cookie');
});

Route::group(['prefix' => 'v1', 'as' => 'v1.'], function () {

    Route::middleware('auth:sanctum')->group(function () {

        Route::get('/user', [UserController::class, 'user'])->name('user');

        Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
            Route::get('/', [ProfileController::class, 'show'])->name('show');
            Route::get('/s3avatar', [ProfileController::class, 'getAvatarFromS3'])->name('show.s3avatar');
            Route::patch('/', [ProfileController::class, 'update'])->name('update');
            Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
        });

        Route::apiResource('albums', AlbumController::class);
        Route::group(['prefix' => 'albums', 'as' => 'albums.'], function () {
            Route::get('/{album}/s3cover', [AlbumController::class, 'getCoverFromS3'])->name('show.s3cover');
        });

        Route::apiResource('albums.posts', AlbumPostController::class)->only(['index']);

        Route::apiResource('posts', PostController::class)->only('index');


    });
});
