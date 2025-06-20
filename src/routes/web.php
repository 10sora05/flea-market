<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CommentController;

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

Route::get('/', [ItemController::class, 'index'])->name('index');

Route::get('/items/{id}', [ItemController::class, 'show'])->name('items.show');

Route::get('/api/search', [ItemController::class, 'search'])->name('items.search');

// 商品購入ページ（ログイン必須）
Route::get('/items/{id}/purchase', [ItemController::class, 'purchase'])
    ->middleware('auth')->name('items.purchase');

// いいね機能（ログイン必須）
Route::post('/items/{item}/like', [LikeController::class, 'like'])->middleware('auth')->name('items.like');
Route::delete('/items/{item}/unlike', [LikeController::class, 'unlike'])->middleware('auth')->name('items.unlike');

// ダッシュボード（認証後）
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

Route::post('/login', [LoginController::class, 'login']);

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');

Route::post('/register', [RegisterController::class, 'register']);

Route::middleware('auth')->post('/items/{item}/comment', [CommentController::class, 'store'])->name('comment.store');

Route::get('/mypage', function () {
  return view('mypage');
})->name('mypage');

Route::get('/sell', function () {
  return view('sell');
})->name('sell');

Route::get('/detail', function () {
  return view('detail');
})->name('detail');

Route::get('/purchase', function () {
  return view('purchase');
})->name('purchase');
