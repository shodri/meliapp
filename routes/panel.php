<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Panel\ProductController;
use App\Http\Controllers\Panel\ApiProductController;
use App\Http\Controllers\Panel\NotificationController;

/*
|--------------------------------------------------------------------------
| Panel Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', 'PanelController@index')->name('panel');

Route::get('user', [ApiProductController::class, 'showUser'])->name('products.showuser');


Route::get('updatevehicles', [ApiProductController::class, 'updateVehicles'])->name('meli.updatevehicles');
Route::get('updatevehicle', [ApiProductController::class, 'updateVehicle'])->name('meli.updatevehicle');
Route::get('description', [ApiProductController::class, 'getItemDescription'])->name('meli.getItemDescription');
Route::get('questions', [ApiProductController::class, 'getItemQuestions'])->name('meli.getItemQuestions');
Route::get('sync', [ApiProductController::class, 'sync'])->name('meli.sync');
Route::post('answer/{question}', [ApiProductController::class, 'answerQuestion'])->name('meli.answer');
// Route::get('showvehicle/{meliId}', [ApiProductController::class, 'showVehicle'])->name('products.showvehicle');

Route::get('notifications/get', [NotificationController::class, 'getNotificationsData'])->name('notifications.get');
Route::get('notifications/{question}/question', [NotificationController::class, 'question'])->name('notifications.question');
Route::resource('notifications', 'NotificationController');

Route::resource('banners', 'BannerController');




Route::get('products/{title}-{id}', [ProductController::class, 'showProduct'])->name('products.show');

Route::get('products/{title}-{id}/purchase', [ProductController::class, 'purchaseProduct'])->name('products.purchase');

Route::get('products/publish', [ProductController::class, 'showPublishProductForm'])->name('products.publish');

Route::post('products/publish', [ProductController::class, 'publishProduct']);


Route::resource('products', 'ProductController');

Route::resource('locations', 'LocationController');

Route::resource('vehicles', 'VehicleController');

Route::post('vehicles/getVehicles', 'VehicleController@getVehicles')->name('vehicles.getVehicles');

Route::post('vehicle/getModels', 'VehicleController@getModels')->name('vehicle.getModels');

Route::post('vehicle/getVersions', 'VehicleController@getVersions')->name('vehicle.getVersions');


Route::get('users', 'UserController@index')->name('users.index');

Route::post('users/admin/{user}', 'UserController@toggleAdmin')
    ->name('users.admin.toggle');

