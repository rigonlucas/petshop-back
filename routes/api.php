<?php

use App\Http\Controllers\Accounts\UsersOfAccountController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Breeds\BreedListController;
use App\Http\Controllers\Clients\ClientListController;
use App\Http\Controllers\Clients\ClientShowController;
use App\Http\Controllers\Pet\PetListController;
use App\Http\Controllers\Products\ProductDeleteController;
use App\Http\Controllers\Products\ProductListController;
use App\Http\Controllers\Products\ProductRestoreController;
use App\Http\Controllers\Products\ProductShowController;
use App\Http\Controllers\Products\ProductStoreController;
use App\Http\Controllers\Products\ProductUpdateController;
use App\Http\Controllers\Schedules\ScheduleDeleteController;
use App\Http\Controllers\Schedules\ScheduleListController;
use App\Http\Controllers\Schedules\ScheduleStoreController;
use App\Http\Controllers\Schedules\ScheduleUpdateController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login'])->name('api.login');
Route::post('/register', [AuthController::class, 'register'])->name('api.register');
Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout')->middleware( 'auth:sanctum');

Route::middleware('auth:sanctum')->get('/user', function () {
    return auth()->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('v1')->group(function (){
        /**
         * Schedules
         */
        Route::prefix('schedules')->group(function () {
            Route::get('/', [ScheduleListController::class, '__invoke'])
                ->name('schedules.index');
        });

        Route::prefix('schedule')->group(function () {
            Route::post('store', [ScheduleStoreController::class, '__invoke'])
                ->name('schedule.store');
            Route::put('update/{scheduleId}', [ScheduleUpdateController::class, '__invoke'])
                ->name('schedule.update');
            Route::delete('delete/{scheduleId}', [ScheduleDeleteController::class, '__invoke'])
                ->name('schedule.delete');
        });

        /**
         * Clients
         */
        Route::prefix('clients')->group(function () {
            Route::get('/', [ClientListController::class, '__invoke']);
        });
        Route::prefix('client')->group(function (){
            Route::prefix('{clientId}')->group(function () {
                Route::get('/', [ClientShowController::class, '__invoke'])
                    ->where('clientId', '[0-9]+');
            });
        });

        /**
         * Pets
         */
        Route::prefix('pets')->group(function () {
            Route::get('/', [PetListController::class, '__invoke']);
        });

        /**
         * Products
         */
        Route::prefix('products')->group(function () {
            Route::get('/', [ProductListController::class, '__invoke']);
        });
        Route::prefix('product')->group(function () {
            Route::post('store', [ProductStoreController::class, '__invoke']);
            Route::put('update/{productId}', [ProductUpdateController::class, '__invoke']);
            Route::get('show/{productId}', [ProductShowController::class, '__invoke']);
            Route::delete('delete/{productId}', [ProductDeleteController::class, '__invoke']);
            Route::get('restore/{productId}', [ProductRestoreController::class, '__invoke']);
        });

        /**
         * Breeds
         */
        Route::prefix('breeds')->group(function () {
            Route::get('/', [BreedListController::class, '__invoke']);

        });

        /**
         * Accounts
         */
        Route::prefix('account')->group(function () {
            Route::get('users', [UsersOfAccountController::class, '__invoke']);
        });
    });
});
