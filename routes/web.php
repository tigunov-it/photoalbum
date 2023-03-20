<?php

use App\Http\Controllers\AlbumsController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ProfilesController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\PostsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

// Верификация электронной почты
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');




Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::match(['get', 'post'],'/p/create', [PostsController::class, 'create'])->name('post.create');

Route::post('/p', [PostsController::class, 'store']);
Route::get('/p/{user}/{post}', [PostsController::class, 'show']);
Route::get('/s3small/{user}/{post}', [PostsController::class, 'getSmallImageFromS3'])->name('post.getSmallFromS3');
Route::get('/s3medium/{user}/{post}', [PostsController::class, 'getMediumImageFromS3'])->name('post.getMediumFromS3');
Route::get('/s3large/{user}/{post}', [PostsController::class, 'getLargeImageFromS3'])->name('post.getLargeFromS3');
Route::get('/s3full/{user}/{post}', [PostsController::class, 'getFullImageFromS3'])->name('post.getFullFromS3');
Route::match(['get', 'delete'],'/p/{post}', [PostsController::class, 'destroy'])->name('post.destroy');
//Route::delete('/p/{post}', [PostsController::class, 'destroy'])->name('post.destroy');

Route::get('/download/{user}/{post}', [ImageController::class, 'download'])->name('image.download');

Route::get('{post}', [ImageController::class, 'rotate'])->name('post.rotate');

Route::get('/a/create', [AlbumsController::class, 'create']);
Route::post('/a', [AlbumsController::class, 'store']);
Route::get('/a/{user}', [AlbumsController::class, 'index'])->name('albums.index');
Route::get('/a/{user}/{album}', [AlbumsController::class, 'show'])->name('albums.show');
Route::get('/s3album/{user}/{album}', [AlbumsController::class, 'getCoverFromS3'])->name('album.getCoverFromS3');
Route::get('/downloadzip/{user}/{album}', [ImageController::class, 'downloadZip'])->name('album.downloadZip');
Route::match(['get', 'delete'],'/album/{album}', [AlbumsController::class, 'destroy'])->name('album.destroy');


Route::get('/profile/{user}', [ProfilesController::class, 'index'])->name('profile.show');
Route::get('/profile/{user}/edit', [ProfilesController::class, 'edit'])->name('profile.edit');
Route::patch('/profile/{user}', [ProfilesController::class, 'update'])->name('profile.update');
Route::get('/s3avatar/{user}', [ProfilesController::class, 'getAvatarFromS3'])->name('profile.getAvatarFromS3');

