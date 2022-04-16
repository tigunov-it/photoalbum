<?php

use App\Http\Controllers\AlbumsController;
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
Route::get('/p/create', [PostsController::class, 'create'])->name('post.create');

Route::post('/p', [PostsController::class, 'store']);
Route::get('/p/{post}', [PostsController::class, 'show']);
Route::delete('/p/{post}', [PostsController::class, 'destroy'])->name('post.destroy');

Route::get('/a/create', [AlbumsController::class, 'create']);
Route::post('/a', [AlbumsController::class, 'store']);
Route::get('/a/{user}', [AlbumsController::class, 'index'])->name('albums.show');

Route::get('/profile/{user}', [ProfilesController::class, 'index'])->name('profile.show');
Route::get('/profile/{user}/edit', [ProfilesController::class, 'edit'])->name('profile.edit');
Route::patch('/profile/{user}', [ProfilesController::class, 'update'])->name('profile.update');

