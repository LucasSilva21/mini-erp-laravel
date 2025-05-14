<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderWebhookController;

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


Route::resource('products', ProductController::class);

Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

Route::post('/cart/remove/{productId}', [CartController::class, 'remove'])->name('cart.remove');

Route::post('/webhook/pedidos', [OrderWebhookController::class, 'handle']);

Route::resource('coupons', CouponController::class);

Route::post('/finalizar-pedido', [OrderController::class, 'store'])->name('orders.store');

Route::post('/webhook/pedidos', [OrderWebhookController::class, 'handle']);

Route::get('/', function () {
    return view('home');
});
