<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\CustomerPurchasesController;
use App\Http\Controllers\DesignController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\HistoryDepositsController;
use App\Http\Controllers\HistorySalesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LicensesController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\PaymentWidgetController;
use App\Http\Controllers\PayTermialController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ReturnInfoController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\SoundController;
use App\Http\Controllers\TariffsController;
use App\Http\Controllers\TariffStatisticController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserGroupController;
use App\Http\Controllers\UserInfoController;
use App\Http\Controllers\VersionController;
use App\Http\Controllers\WarehouseController;
use Illuminate\Support\Facades\Artisan;
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

Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('config:cache');

    return "Cache cleared successfully";
});
Route::get('test', [TestController::class, 'index'])->name('testIndex');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('finduser', [App\Http\Controllers\UserController::class, 'UserFindShow'])->name('UserFindShow');
Route::get('game', [GameController::class, 'index'])->name('game');
Route::get('finance', [FinanceController::class, 'index'])->name('finance');
Route::get('booking', [BookingController::class, 'index'])->name('booking');
Route::get('shop', [ShopController::class, 'index'])->name('shop');
Route::get('map', [MapController::class, 'index'])->name('map');
Route::get('promo', [PromoController::class, 'index'])->name('promo');
Route::get('dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
Route::get('task', [TaskController::class, 'index'])->name('task');
Route::get('userinfo', [UserInfoController::class, 'index'])->name('userinfo');
Route::get('warehouse', [WarehouseController::class, 'index'])->name('warehouse');
Route::get('tariffs', [TariffsController::class, 'index'])->name('tariffs');
Route::get('pay_terminal', [PayTermialController::class, 'index'])->name('pay_terminal');
Route::get('position', [PositionController::class, 'index'])->name('position');
Route::get('licenses', [LicensesController::class, 'index'])->name('licenses');
Route::get('design', [DesignController::class, 'index'])->name('design');
Route::get('users-group', [UserGroupController::class, 'index'])->name('users-group');
Route::get('history-deposits', [HistoryDepositsController::class, 'index'])->name('historyDeposits');
Route::get('history-sales', [HistorySalesController::class, 'index'])->name('history-sales');
Route::get('tariff_statistic', [TariffStatisticController::class, 'index'])->name('tariff_statistic');
Route::get('registration', [RegistrationController::class, 'registration'])->name('registration');
Route::get('sound', [SoundController::class, 'index'])->name('sound');
Route::get('receipt', [ReceiptController::class, 'index'])->name('receipt');
Route::get('version', [VersionController::class, 'index'])->name('version');
Route::get('customer-purchases', [CustomerPurchasesController::class, 'index'])->name('customerPurchases');
Route::get('return-info', [ReturnInfoController::class, 'index'])->name('returnInfo');
Route::get('payment/{client}/{summa}', [PaymentWidgetController::class, 'index'])->name('payment');

