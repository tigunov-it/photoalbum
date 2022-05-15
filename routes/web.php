<?php

use App\Http\Controllers\AlbumsController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ProfilesController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\PostsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::match(['get', 'post'],'/p/create', [PostsController::class, 'create'])->name('post.create');

Route::post('/p', [PostsController::class, 'store']);
Route::get('/p/{user}/{post}', [PostsController::class, 'show']);
Route::get('/s3/{user}/{post}', [PostsController::class, 'getSmallImageFromS3'])->name('post.getFromS3');
Route::get('/s3full/{user}/{post}', [PostsController::class, 'getFullImageFromS3'])->name('post.getFullFromS3');
Route::delete('/p/{post}', [PostsController::class, 'destroy'])->name('post.destroy');

//TODO: Настроить rotate
Route::get('{post}', [ImageController::class, 'rotate'])->name('post.rotate');


Route::get('/a/create', [AlbumsController::class, 'create']);
Route::post('/a', [AlbumsController::class, 'store']);
Route::get('/a/{user}', [AlbumsController::class, 'index'])->name('albums.index');
Route::get('/a/{user}/{album}', [AlbumsController::class, 'show'])->name('albums.show');


Route::get('/profile/{user}', [ProfilesController::class, 'index'])->name('profile.show');
Route::get('/profile/{user}/edit', [ProfilesController::class, 'edit'])->name('profile.edit');
Route::patch('/profile/{user}', [ProfilesController::class, 'update'])->name('profile.update');
Route::get('/s3avatar/{user}', [ProfilesController::class, 'getAvatarFromS3'])->name('profile.getAvatarFromS3');


