<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\PurchaseController;

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
Route::get('/mypage', [ProfileController::class, 'mypage'])->name('profile.mypage');

// 購入画面表示（GET）
Route::get('/purchase/{item}', [PurchaseController::class, 'showPurchasePage'])
    ->middleware('auth')
    ->name('items.purchase.show');

// 購入処理（POST）
Route::post('/purchase/{item}', [PurchaseController::class, 'purchase'])
    ->middleware('auth')
    ->name('items.purchase');

// いいね機能（ログイン必須）
Route::post('/items/{item}/like', [LikeController::class, 'like'])->middleware('auth')->name('items.like');
Route::delete('/items/{item}/unlike', [LikeController::class, 'unlike'])->middleware('auth')->name('items.unlike');

// 認証関連
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// コメント投稿（認証必須）
Route::middleware('auth')->post('/items/{item}/comment', [CommentController::class, 'store'])->name('comment.store');

// 認証グループ
Route::middleware('auth')->group(function () {
    Route::get('/profile/mypage', [ProfileController::class, 'mypage'])->name('profile.mypage');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/edit', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/address', [ProfileController::class, 'address'])->name('profile.address');
    Route::post('/profile/address', [ProfileController::class, 'addressUpdate'])->name('profile.address.update');
    Route::get('/sell', [SellController::class, 'create'])->name('sell');
    Route::post('/items', [SellController::class, 'store'])->name('items.store');
});
