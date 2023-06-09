<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('finduser', [App\Http\Controllers\UserController::class, 'UserFindShow'])->name('UserFindShow');
Route::get('game', [\App\Http\Controllers\GameController::class, 'index'])->name('game');
Route::get('finance', [\App\Http\Controllers\FinanceController::class, 'index'])->name('finance');
Route::get('booking', [\App\Http\Controllers\BookingController::class, 'index'])->name('booking');
Route::get('shop', [\App\Http\Controllers\ShopController::class, 'index'])->name('shop');
Route::get('map', [\App\Http\Controllers\MapController::class, 'index'])->name('map');
Route::get('promo', [\App\Http\Controllers\PromoController::class, 'index'])->name('promo');
Route::get('dashboard', [\App\Http\Controllers\HomeController::class, 'dashboard'])->name('dashboard');
Route::get('task', [\App\Http\Controllers\TaskController::class, 'index'])->name('task');
Route::get('userinfo', [\App\Http\Controllers\UserInfoController::class, 'index'])->name('userinfo');
Route::get('warehouse', [\App\Http\Controllers\WarehouseController::class, 'index'])->name('warehouse');
Route::get('tariffs', [\App\Http\Controllers\TariffsController::class, 'index'])->name('tariffs');
Route::get('pay_terminal', [\App\Http\Controllers\PayTermialController::class, 'index'])->name('pay_terminal');
Route::get('position', [\App\Http\Controllers\PositionController::class, 'index'])->name('position');
Route::get('licenses', [\App\Http\Controllers\LicensesController::class, 'index'])->name('licenses');
Route::get('design', [\App\Http\Controllers\DesignController::class, 'index'])->name('design');




Route::get('test', [\App\Http\Controllers\TestController::class, 'index'])->name('testIndex');

