<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\HomeController;
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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/',[HomeController::class, 'index'])->name('home');

Auth::routes();
Route::get('/p/create', [PostsController::class, 'create']);
Route::post('/p', [PostsController::class, 'store']);
Route::get('/p/{post}', [PostsController::class, 'show']);


Route::get('/profile/{user}', [ProfilesController::class, 'index'])->name('profile.show');
Route::get('/profile/{user}/edit', [ProfilesController::class, 'edit'])->name('profile.edit');
Route::patch('/profile/{user}', [ProfilesController::class, 'update'])->name('profile.update');



// для админа
Route::get('/admin',[AdminController::class,'index'])->name('admin.index');