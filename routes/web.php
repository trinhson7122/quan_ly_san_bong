<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BankInformationController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\FootballPitchController;
use App\Http\Controllers\FootballPitchDetailController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PitchTypeController;
use App\Models\BankInformation;
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
//client
Route::view('test', 'client.master')->name('test');
Route::controller(ClientController::class)->group(function () {
    Route::name('client.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('san-bong/{id}', 'footballPitchDetail')->name('footballPitchDetail');
        Route::get('checkout/{id}', 'checkout')->name('checkout');
        Route::get('findOderByCode', 'findOrderByCode')->name('findOrderByCode');
    });
});
Route::middleware('client')->group(function () {
    Route::controller(AuthController::class)->group(function (){
        Route::get('logout', 'processClientLogout')->name('client.logout');
    });
});
Route::middleware('not_client')->group(function () {
    Route::controller(AuthController::class)->group(function (){
        Route::get('login', 'clientLogin')->name('client.login');
        Route::get('register', 'clientRegister')->name('client.register');
    });
});
//admin
Route::middleware('admin')->group(function () {
    Route::prefix('admin')->group(function () {
        Route::name('admin.')->group(function () {
            Route::controller(AdminController::class)->group(function () {
                Route::get('/', 'dashboard')->name('dashboard');
                Route::get('pitchType', 'pitchType')->name('pitchType');
                Route::get('footballPitch', 'footballPitch')->name('footballPitch');
                Route::get('footballPitchDetail/{id}', 'footballPitchDetail')->name('footballPitchDetail');
                Route::get('order-calendar', 'orderCalendar')->name('orderCalendar');
                Route::get('order-table', 'orderTable')->name('orderTable');
                Route::get('checkout-order/{id?}', 'checkout')->name('checkout');
                Route::get('bank-information', 'bankInformation')->name('bankInformation');
            });
            Route::controller(AuthController::class)->group(function () {
                Route::get('logout', 'processAdminLogout')->name('logout');
            });
        });
        Route::name('pitchType.')->group(function () {
            Route::controller(PitchTypeController::class)->group(function () {
                Route::post('pitch_type', 'store')->name('store');
                Route::put('pitch_type/{id}', 'update')->name('update');
                Route::delete('pitch_type/{id}', 'destroy')->name('destroy');
                Route::get('pitch_type/{id}', 'show')->name('show');
            });
        });
        Route::name('footballPitch.')->group(function () {
            Route::controller(FootballPitchController::class)->group(function () {
                Route::post('footballPitch', 'store')->name('store');
                Route::put('footballPitch/{id}', 'update')->name('update');
                Route::get('footballPitch/{id}', 'show')->name('show');
            });
        });
        Route::name('footballPitchDetail.')->group(function () {
            Route::controller(FootballPitchDetailController::class)->group(function () {
                Route::post('footballPitchDetail', 'store')->name('store');
                Route::delete('footballPitchDetail/{id}', 'destroy')->name('destroy');
            });
        });
    });
});
Route::middleware('not_admin')->group(function () {
    Route::prefix('admin')->group(function () {
        Route::controller(AuthController::class)->group(function () {
            Route::get('login', 'adminLogin')->name('admin.login');
            Route::post('login', 'processAdminLogin')->name('admin.processLogin');
        });
    });
});

//api
Route::prefix('api')->group(function () {
    Route::controller(FootballPitchController::class)->group(function () {
        Route::get('footballPitch', 'index')->name('footballPitch.index');
        Route::put('footballPitchMaintenance/{id}', 'maintenance')->name('footballPitch.maintenance');
        Route::delete('footballPitch/{id}', 'destroy')->name('destroy');
    });
    Route::controller(OrderController::class)->group(function () {
        Route::get('order', 'showAll')->name('order.showAll');
        Route::get('order_all', 'index')->name('order.index');
        Route::get('order/{id}', 'show')->name('order.show');
        Route::get('getOrderUnpaid', 'getOrderUnpaid')->name('order.getOrderUnpaid');
        Route::get('check_order', 'check')->name('order.check');
        Route::get('find_time', 'findTimeAvailable')->name('order.findTimeAvailable');
        Route::post('findFootballPitchNotInOrderByDateTime', 'findFootballPitchNotInOrderByDateTime')->name('order.findFootballPitchNotInOrderByDateTime');
        Route::post('client_store', 'clientStore')->name('order.clientStore');
    });
    Route::controller(BankInformationController::class)->group(function () {
        Route::get('bank_information', 'index')->name('order.index');
    });
    Route::middleware('admin')->group(function () {
        Route::controller(OrderController::class)->group(function () {
            Route::put('order/{id}', 'update')->name('order.update');
            Route::post('order', 'store')->name('order.store');
            Route::put('order-paid/{id}', 'paid')->name('order.paid');
            Route::delete('order/{id}', 'destroy')->name('order.destroy');
        });
        Route::controller(BankInformationController::class)->group(function () {
            Route::post('bank_information', 'store')->name('bank_information.store');
            Route::put('bank_information/{id}', 'update')->name('bank_information.update');
            Route::get('bank_information/{id}', 'show')->name('bank_information.show');
            Route::delete('bank_information/{id}', 'destroy')->name('bank_information.destroy');
            Route::put('bank_information_change_display/{id}', 'change_display')->name('bank_information.change_display');
        });
    });
});
