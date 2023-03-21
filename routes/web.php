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



Route::get('test', [\App\Http\Controllers\TestController::class, 'index'])->name('testIndex');


//Route::post('save', [\App\Http\Controllers\MapController::class, 'saveMapPosition'])->name('saveMapPosition');
