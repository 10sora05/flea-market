<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;

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

Route::get('/purchase/{id}', [ItemController::class, 'purchase'])->name('items.purchase');

Route::get('/login', function () {
  return view('login');
})->name('login');

Route::get('/register', function () {
  return view('register');
})->name('register');

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
