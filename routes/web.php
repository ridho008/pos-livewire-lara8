<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Product;
use App\Http\Livewire\Cart;
use App\Http\Livewire\History;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Auth\Register;
use App\Http\Livewire\Auth\Logout;
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


// Auth::routes();

Route::group(['middleware' => ['guest']], function() {
   Route::get('/login', Login::class)->name('login');
   Route::get('/register', Register::class)->name('register');
   Route::get('/', function () {
       return view('welcome');
   });
});

Route::group(['middleware' => ['auth']], function() {
   Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
   Route::get('/products', Product::class)->name('product.index');
   Route::get('/history', History::class)->name('history.index');
   Route::get('/cart', Cart::class)->name('cart.index');
   Route::get('/logout', Logout::class)->name('logout');
});