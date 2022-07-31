<?php

use App\Http\Controllers\Accounts\UsersOfAccountController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Breeds\BreedListController;
use App\Http\Controllers\Clients\ClientDeleteController;
use App\Http\Controllers\Clients\ClientListController;
use App\Http\Controllers\Clients\ClientShowController;
use App\Http\Controllers\Clients\ClientStoreController;
use App\Http\Controllers\Clients\ClientUpdateController;
use App\Http\Controllers\Pet\PetDeleteController;
use App\Http\Controllers\Pet\PetListController;
use App\Http\Controllers\Pet\PetStoreController;
use App\Http\Controllers\Pet\PetUpdateController;
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
                ->where('scheduleId', '[0-9]+')
                ->name('schedule.update');
            Route::delete('delete/{scheduleId}', [ScheduleDeleteController::class, '__invoke'])
                ->where('scheduleId', '[0-9]+')
                ->name('schedule.delete');
        });

        /**
         * Clients
         */
        Route::prefix('clients')->group(function () {
            Route::get('/', [ClientListController::class, '__invoke'])
                ->name('client.index');
        });
        Route::prefix('client')->group(function (){
            Route::prefix('{clientId}')->group(function () {
                Route::get('/', [ClientShowController::class, '__invoke'])
                    ->where('clientId', '[0-9]+');
            });
            Route::post('store', [ClientStoreController::class, '__invoke'])
                ->name('client.store');
            Route::put('update/{clientId}', [ClientUpdateController::class, '__invoke'])
                ->where('clientId', '[0-9]+')
                ->name('client.update');;
            Route::delete('delete/{clientId}', [ClientDeleteController::class, '__invoke'])
                ->where('clientId', '[0-9]+')
                ->name('client.delete');;
        });

        /**
         * Pets
         */
        Route::prefix('pets')->group(function () {
            Route::get('/', [PetListController::class, '__invoke'])
                ->name('pet.index');
        });
        Route::prefix('pet')->group(function () {
            Route::post('store', [PetStoreController::class, '__invoke'])
                ->name('pet.store');;
            Route::put('update/{petId}', [PetUpdateController::class, '__invoke'])
                ->where('petId', '[0-9]+')
                ->name('pet.update');;
            Route::delete('delete/{petId}', [PetDeleteController::class, '__invoke'])
                ->where('petId', '[0-9]+')
                ->name('pet.delete');;
        });

        /**
         * Products
         */
        Route::prefix('products')->group(function () {
            Route::get('/', [ProductListController::class, '__invoke']);
        });
        Route::prefix('product')->group(function () {
            Route::post('store', [ProductStoreController::class, '__invoke'])
                ->name('product.store');
            Route::put('update/{productId}', [ProductUpdateController::class, '__invoke'])
                ->where('productId', '[0-9]+')
                ->name('product.update');
            Route::get('show/{productId}', [ProductShowController::class, '__invoke'])
                ->where('productId', '[0-9]+')
                ->name('product.show');
            Route::delete('delete/{productId}', [ProductDeleteController::class, '__invoke'])
                ->where('productId', '[0-9]+')
                ->name('product.delete');
            Route::get('restore/{productId}', [ProductRestoreController::class, '__invoke'])
                ->where('productId', '[0-9]+')
                ->name('product.restore');;
        });

        /**
         * Breeds
         */
        Route::prefix('breeds')->group(function () {
            Route::get('/', [BreedListController::class, '__invoke'])
                ->name('breeds.index');
        });

        /**
         * Accounts
         */
        Route::prefix('account')->group(function () {
            Route::get('users', [UsersOfAccountController::class, '__invoke'])
                ->name('account.index');
        });
    });
});
