<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\FrontController;

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

Route::get('/', 'FrontController@index')->name('front.index');
Route::get('empresa', 'FrontController@empresa')->name('front.empresa');
Route::get('contacto', 'FrontController@contacto')->name('front.contacto');
Route::get('destacados', 'FrontController@destacados')->name('front.destacados');
Route::match(['get', 'post'], 'usados', 'FrontController@usados')->name('front.usados');
Route::get('usado/{vehicle}', 'FrontController@usado')->name('front.usado');
// Route::get('usado/{title}-{id}', [FrontController::class, 'usado'])->name('front.usado');


Route::get('authorization', [LoginController::class, 'authorization'])->name('authorization');

Route::post('loginLocal', [LoginController::class, 'loginLocal'])->name('loginLocal');


Route::get('profile', 'ProfileController@edit')->name('profile.edit');

Route::put('profile', 'ProfileController@update')->name('profile.update');

Route::resource('products.carts', 'ProductCartController')->only(['store', 'destroy']);

Route::resource('carts', 'CartController')->only(['index']);

Route::resource('orders', 'OrderController')
    ->only(['create', 'store'])
    ->middleware(['verified']);

Route::resource('orders.payments', 'OrderPaymentController')
    ->only(['create', 'store'])
    ->middleware(['verified']);

Auth::routes([
    'verify' => true,
]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/home/purchases', [App\Http\Controllers\HomeController::class, 'showPurchases'])->name('purchases');

Route::get('/home/products', [App\Http\Controllers\HomeController::class, 'showProducts'])->name('products');

