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

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('v1')->group(function (){
        Route::get('/user', function () {
            return auth()->user();
        });

        /**
         * Schedules
         */
        Route::prefix('schedules')->group(function () {
            Route::get('/', ScheduleListController::class)
                ->name('schedules.index');
        });

        Route::prefix('schedule')->group(function () {
            Route::post('', ScheduleStoreController::class)
                ->name('schedule.store');
            Route::prefix('{id}')->group(function () {
                Route::put('/', ScheduleUpdateController::class)
                    ->name('schedule.update');
                Route::delete('/', ScheduleDeleteController::class)
                    ->name('schedule.delete');
            });
        });

        /**
         * Clients
         */
        Route::prefix('clients')->group(function () {
            Route::get('/', ClientListController::class)
                ->name('client.index');
        });
        Route::prefix('client')->group(function (){
            Route::post('/', ClientStoreController::class)
                ->name('client.store');
            Route::get('/', ClientShowController::class)
                ->name('client.index');
            Route::prefix('{id}')->group(function () {
                Route::put('/', ClientUpdateController::class)
                    ->name('client.update');
                Route::delete('/', ClientDeleteController::class)
                    ->name('client.delete');//necessário validar os pets
            });
        });

        /**
         * Pets
         */
        Route::prefix('pets')->group(function () {
            Route::get('/', PetListController::class)
                ->name('pet.index');
        });
        Route::prefix('pet')->group(function () {
            Route::post('/', PetStoreController::class)
                ->name('pet.store');
            Route::put('/{id}', PetUpdateController::class)
                ->name('pet.update');
            Route::delete('/{id}', PetDeleteController::class)
                ->name('pet.delete');
        });

        /**
         * Products
         */
        Route::prefix('products')->group(function () {
            Route::get('/', ProductListController::class);
        });
        Route::prefix('product')->group(function () {
            Route::post('/', ProductStoreController::class)
                ->name('product.store');
            Route::put('/{id}', ProductUpdateController::class)
                ->name('product.update');
            Route::get('/{id}', ProductShowController::class)
                ->name('product.show');
            Route::delete('{id}', ProductDeleteController::class)
                ->name('product.delete');
            Route::patch('{id}/restore', ProductRestoreController::class)
                ->name('product.restore');
        });

        /**
         * Breeds
         */
        Route::prefix('breeds')->group(function () {
            Route::get('/', BreedListController::class)
                ->name('breeds.index');
        });

        /**
         * Accounts
         */
        Route::prefix('account')->group(function () {
            Route::get('users', UsersOfAccountController::class)
                ->name('account.index');
        });
    });
});
