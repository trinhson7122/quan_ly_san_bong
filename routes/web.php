<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PitchTypeController;
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

Route::middleware('admin')->group(function (){
    Route::prefix('admin')->group(function (){
        Route::name('admin.')->group(function (){
            Route::controller(AdminController::class)->group(function (){
                Route::get('/', 'dashboard')->name('dashboard');
                Route::get('pitchType', 'pitchType')->name('pitchType');
                Route::get('footballPitch', 'footballPitch')->name('footballPitch');
            });
            Route::controller(AuthController::class)->group(function (){
                Route::get('logout', 'processAdminLogout')->name('logout');
            });
        });
        Route::name('pitchType.')->group(function (){
            Route::controller(PitchTypeController::class)->group(function (){
                Route::post('pitch_type', 'store')->name('store');
                Route::put('pitch_type/{id}', 'update')->name('update');
                Route::delete('pitch_type/{id}', 'destroy')->name('destroy');
                Route::get('pitch_type/{id}', 'show')->name('show');
            });
        });
    });
});
Route::middleware('not_admin')->group(function (){
    Route::prefix('admin')->group(function (){
        Route::controller(AuthController::class)->group(function (){
            Route::get('login', 'adminLogin')->name('admin.login');
            Route::post('login', 'processAdminLogin')->name('admin.processLogin');
        });
    });
});
