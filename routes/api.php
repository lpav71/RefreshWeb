<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('saveMapPosition', [\App\Http\Controllers\api\MapController::class, 'saveMapPosition'])->name('saveMapPosition');
Route::post('getMapPosition', [\App\Http\Controllers\api\MapController::class, 'getMapPosition'])->name('getMapPosition');
Route::post('saveNewPosition', [\App\Http\Controllers\api\MapController::class, 'saveNewPosition'])->name('saveNewPosition');
Route::post('findusers', [App\Http\Controllers\api\UserController::class, 'UsersFind'])->name('UsersFind');
Route::post('getSmena', [App\Http\Controllers\api\FinanceController::class, 'getSmena'])->name('getSmena');
Route::post('findOpenShift', [App\Http\Controllers\api\FinanceController::class, 'findOpenShift'])->name('findOpenShift');
Route::post('getGames', [App\Http\Controllers\api\GameController::class, 'getGames'])->name('getGames');
Route::post('changeStatus', [App\Http\Controllers\api\GameController::class, 'changeStatus'])->name('changeStatus');
Route::post('searchGame', [App\Http\Controllers\api\GameController::class, 'searchGame'])->name('searchGame');
Route::post('getAllFinance',[\App\Http\Controllers\api\FinanceController::class,'getAllFinance'])->name('getAllFinance');
Route::post('shift/close',[\App\Http\Controllers\WebHooks\ShiftController::class, 'close'])->name('shift.close');
Route::post('shift/open',[\App\Http\Controllers\WebHooks\ShiftController::class, 'open'])->name('shift.open');
Route::post('verifyopenshift',[\App\Http\Controllers\api\FinanceController::class,'verifyOpenShift'])->name('verifyOpenShift');
Route::post('verifycloseshift',[\App\Http\Controllers\api\FinanceController::class,'verifyCloseShift'])->name('verifyCloseShift');
Route::post('games/getGameById', [App\Http\Controllers\api\GameController::class, 'getGameById'])->name('getGameById');
Route::post('games/savegame', [App\Http\Controllers\api\GameController::class, 'saveGame'])->name('saveGame');
Route::post('openOpenModal',[\App\Http\Controllers\WebHooks\ShiftController::class, 'openOpenModal'])->name('openOpenModal');
Route::post('openCloseModal',[\App\Http\Controllers\WebHooks\ShiftController::class, 'openCloseModal'])->name('openCloseModal');
Route::post('zone/getZone', [\App\Http\Controllers\api\ZoneController::class, 'getZone'])->name('getZone');
Route::post('map/findpc', [\App\Http\Controllers\api\MapController::class, 'findPCForAdd'])->name('findPCForAdd');
Route::post('sendMassage',[\App\Http\Controllers\api\FinanceController::class,'sendMassage'])->name('sendMassage');
Route::post('closepay',[\App\Http\Controllers\api\FinanceController::class,'closePaymentWindow'])->name('closePaymentWindow');
Route::post('shop/get', [\App\Http\Controllers\api\ShopController::class, 'getAll']);
Route::post('shop/find', [\App\Http\Controllers\api\ShopController::class, 'find']);
Route::post('client/register', [\App\Http\Controllers\api\ClientController::class, 'register']);


Route::post('testget', [\App\Http\Controllers\TestController::class, 'get'])->name('testGet');

