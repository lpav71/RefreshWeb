<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('saveMapPosition', [\App\Http\Controllers\api\MapController::class, 'saveMapPosition'])->name('saveMapPosition');
Route::post('getMapPosition', [\App\Http\Controllers\api\MapController::class, 'getMapPosition'])->name('getMapPosition');
Route::post('saveNewPosition', [\App\Http\Controllers\api\MapController::class, 'saveNewPosition'])->name('saveNewPosition');
Route::post('findusers', [App\Http\Controllers\api\UserController::class, 'UsersFind'])->name('UsersFind');
Route::post('getSmena', [App\Http\Controllers\api\FinanceController::class, 'getSmena'])->name('getSmena');
Route::post('findopenshift', [App\Http\Controllers\api\FinanceController::class, 'findOpenShift'])->name('findOpenShift');
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
Route::post('client/all', [\App\Http\Controllers\api\ClientController::class, 'getClients']);
Route::post('shop/find/client', [\App\Http\Controllers\api\ShopController::class, 'searchClient']);
Route::post('booking/all', [\App\Http\Controllers\api\BookingController::class, 'getAllClients']);
Route::post('booking/cancel', [\App\Http\Controllers\api\BookingController::class, 'cancelBooking']);
Route::post('zone/add', [\App\Http\Controllers\api\ZoneController::class, 'addZone']);
Route::post('promo/save', [\App\Http\Controllers\api\PromoController::class, 'save']);
Route::post('tasks/tasks', [\App\Http\Controllers\api\TaskController::class, 'tasks']);
Route::post('tasks/users', [\App\Http\Controllers\api\TaskController::class, 'users']);
Route::post('tasks/save', [\App\Http\Controllers\api\TaskController::class, 'saveAddModal']);
Route::post('tasks/new-status', [\App\Http\Controllers\api\TaskController::class, 'getNewStatus']);
Route::post('tasks/save-new-status', [\App\Http\Controllers\api\TaskController::class, 'saveNewStatus']);
Route::post('tasks/all', [\App\Http\Controllers\api\TaskController::class, 'allTasks']);
Route::post('booking/draw', [\App\Http\Controllers\api\BookingController::class, 'draw']);
Route::post('store/addedit', [\App\Http\Controllers\api\ShopController::class, 'addEdit']);
Route::post('price/get0', [\App\Http\Controllers\api\TariffController::class, 'getTariff0']);
Route::post('price/get1', [\App\Http\Controllers\api\TariffController::class, 'getTariff1']);
Route::post('user/getpermissions', [\App\Http\Controllers\api\UserController::class, 'getPermisions']);
Route::post('position/getuser', [\App\Http\Controllers\api\PositionController::class, 'getUsers']);



Route::post('testget', [\App\Http\Controllers\TestController::class, 'get'])->name('testGet');

