<?php


use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\HomeController;

use App\Http\Controllers\AlbumsController;



use App\Http\Controllers\ProfilesController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\PostsController;
use Illuminate\Support\Facades\Auth;

use SebastianBergmann\CodeCoverage\Node\CrapIndex;


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


Auth::routes();
// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('',[HomeController::class, 'index'])->name('home');

Route::get('/p/create', [PostsController::class, 'create'])->name('post.create');

Route::post('/p', [PostsController::class, 'store']);
Route::get('/p/{post}', [PostsController::class, 'show']);
Route::delete('/p/{post}', [PostsController::class, 'destroy'])->name('post.destroy');

Route::get('/a/create', [AlbumsController::class, 'create']);
Route::post('/a', [AlbumsController::class, 'store']);
Route::get('/a/{user}', [AlbumsController::class, 'index'])->name('albums.index');

Route::get('/a/{user}/foto',[AlbumsController::class,'showFoto'])->name('albums.showFoto');

Route::get('/a/{user}/{album}', [AlbumsController::class, 'show'])->name('albums.show');



Route::get('/profile/{user}', [ProfilesController::class, 'index'])->name('profile.show');
Route::get('/profile/{user}/edit', [ProfilesController::class, 'edit'])->name('profile.edit');
Route::patch('/profile/{user}', [ProfilesController::class, 'update'])->name('profile.update');




// для админа
Route::get('/admin',[AdminController::class,'index'])->name('admin.index');

// Route::get('/',[HomeController::class, 'index'])->name('home');

