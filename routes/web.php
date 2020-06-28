<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Auth;


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

Route::get('/', [ OrdersController::class, 'index'])->name('home');

Route::get('login', [ LoginController::class, 'showLoginForm' ])->name('login');
Route::post('login', [ LoginController::class, 'login'] );
Route::post('logout', [ LoginController::class, 'logout'])->name('logout');
if(env('REGISTRATION_ACTIVE', 0))
{
    Route::get('register', [ RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [ RegisterController::class, 'register']);
}

Route::get('/home', [ HomeController::class, 'index'])->name('home');
Route::get('/products', [ ProductsController::class, 'index'])->name('products.index');
Route::post('/products', [ ProductsController::class, 'store'])->name('products.store');
Route::get('/products/search', [ProductsController::class, 'search'])->name('products.search');
Route::get('/products/{id}/edit', [ProductsController::class, 'edit'])->name('products.edit');
Route::put('/products/{id}', [ProductsController::class, 'update'])->name('products.update');
Route::get('/products/{product}', [ ProductsController::class , 'show' ])->name('products.show');
Route::post('/orders/toggle-receive/{id}', [OrdersController::class, 'togglereceive'])->name('orders.togglereceive');
Route::get('/orders', [ OrdersController::class, 'index'])->name('orders.index');
Route::get('/orders/allorders', [ OrdersController::class, 'allorders'])->name('orders.allorders');
Route::get('/orders/{id}/edit', [OrdersController::class, 'edit'])->name('orders.edit');
Route::put('/orders/{id}', [OrdersController::class, 'update'])->name('orders.update');
Route::get('/orders/{order}', [ OrdersController::class, 'show'])->name('orders.show');
Route::post('/orders', [ OrdersController::class, 'store'])->name('orders.store');
