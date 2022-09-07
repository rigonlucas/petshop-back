<?php

use App\Http\Controllers\Accounts\ChangeUserStatusController;
use App\Http\Controllers\Accounts\UserCreateController;
use App\Http\Controllers\Accounts\UsersOfAccountController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\UpdatePasswordController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Breeds\BreedListController;
use App\Http\Controllers\Clients\ClientDeleteController;
use App\Http\Controllers\Clients\ClientListController;
use App\Http\Controllers\Clients\ClientShowController;
use App\Http\Controllers\Clients\ClientStoreController;
use App\Http\Controllers\Clients\ClientUpdateController;
use App\Http\Controllers\Pet\PetDeleteController;
use App\Http\Controllers\Pet\PetListController;
use App\Http\Controllers\Pet\PetShowController;
use App\Http\Controllers\Pet\PetStoreController;
use App\Http\Controllers\Pet\PetUpdateController;
use App\Http\Controllers\Products\ProductDeleteController;
use App\Http\Controllers\Products\ProductListController;
use App\Http\Controllers\Products\ProductRestoreController;
use App\Http\Controllers\Products\ProductShowController;
use App\Http\Controllers\Products\ProductStoreController;
use App\Http\Controllers\Products\ProductUpdateController;
use App\Http\Controllers\ScheduleHistory\ScheduleHistoryDeleteController;
use App\Http\Controllers\ScheduleHistory\ScheduleHistoryIndexController;
use App\Http\Controllers\ScheduleHistory\ScheduleHistoryStoreController;
use App\Http\Controllers\ScheduleProducts\ScheduleProductsDeleteController;
use App\Http\Controllers\ScheduleProducts\ScheduleProductsStoreController;
use App\Http\Controllers\Schedules\AvailableProfessionalsController;
use App\Http\Controllers\Schedules\ScheduleDeleteController;
use App\Http\Controllers\Schedules\ScheduleListController;
use App\Http\Controllers\Schedules\ScheduleShowController;
use App\Http\Controllers\Schedules\ScheduleStoreController;
use App\Http\Controllers\Schedules\ScheduleUpdateController;
use App\Http\Controllers\Schedules\Status\SchedulesArchivedController;
use App\Http\Controllers\Schedules\Status\SchedulesCanceledController;
use App\Http\Controllers\Schedules\Status\SchedulesExecutingController;
use App\Http\Controllers\Schedules\Status\SchedulesFinishedController;
use App\Http\Controllers\Schedules\Status\SchedulesOpenController;
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
Route::prefix('v1')->group(function () {

    Route::post('/login', LoginController::class)
        ->name('api.login');
    Route::post('/register', RegisterController::class)
        ->name('api.register');
    Route::get('/verify-email/{hash}', VerifyEmailController::class)
        ->name('api.verify-email');
    Route::patch('/forgot-password', ForgotPasswordController::class)
        ->name('api.forgot-password');
    Route::patch('/update-password/{hash}', UpdatePasswordController::class)
        ->name('api.update-password');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/logout', LogoutController::class)
            ->name('api.logout');

        Route::get('/user', function () {
            return auth()->user();
        });
        /**
         * Schedules
         */
        Route::prefix('schedules')->group(function () {
            Route::get('/', ScheduleListController::class)
                ->name('schedules.index');
            Route::get('professionals/available', AvailableProfessionalsController::class)
                ->name('available.schedules.professionals');
        });

        Route::prefix('schedule')->group(function () {
            Route::post('', ScheduleStoreController::class)
                ->name('schedule.store');
            Route::prefix('{id}')->group(function () {
                Route::get('/', ScheduleShowController::class)
                    ->name('schedule.get');
                Route::put('/', ScheduleUpdateController::class)
                    ->name('schedule.update');
                Route::delete('/', ScheduleDeleteController::class)
                    ->name('schedule.delete');
                Route::prefix('status')->group(function () {
                    Route::patch('open', SchedulesOpenController::class)
                        ->name('schedule.status.open');
                    Route::patch('executing', SchedulesExecutingController::class)
                        ->name('schedule.status.executing');
                    Route::patch('archived', SchedulesArchivedController::class)
                        ->name('schedule.status.archived');
                    Route::patch('canceled', SchedulesCanceledController::class)
                        ->name('schedule.status.canceled');
                    Route::patch('finished', SchedulesFinishedController::class)
                        ->name('schedule.status.finished');
                });
                Route::prefix('history')->group(function () {
                    Route::prefix('/{scheduleId}')->group(function () {
                        Route::delete('/', ScheduleHistoryDeleteController::class)
                            ->name('schedule.history.delete');
                    });
                    Route::get('/', ScheduleHistoryIndexController::class)
                        ->name('schedule.history.index');
                    Route::post('/', ScheduleHistoryStoreController::class)
                        ->name('schedule.history.store');
                });
                Route::prefix('products')->group(function () {
                    Route::post('/', ScheduleProductsStoreController::class)
                        ->name('schedule.products.store');
                    Route::prefix('{scheduleProductId}')->group(function () {
                        Route::delete('/', ScheduleProductsDeleteController::class)
                            ->name('schedule.products.delete');
                    });
                });
            });
        });

        /**
         * Clients
         */
        Route::prefix('clients')->group(function () {
            Route::get('/', ClientListController::class)
                ->name('client.index');
        });
        Route::prefix('client')->group(function () {
            Route::post('/', ClientStoreController::class)
                ->name('client.store');
            Route::prefix('{id}')->group(function () {
                Route::get('/', ClientShowController::class)
                    ->name('client.show');
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
            Route::prefix('/{id}')->group(function () {
                Route::get('/', PetShowController::class)
                    ->name('pet.show');
                Route::put('/', PetUpdateController::class)
                    ->name('pet.update');
                Route::delete('/', PetDeleteController::class)
                    ->name('pet.delete');
            });
        });

        /**
         * Products
         */
        Route::prefix('products')->group(function () {
            Route::get('/', ProductListController::class)
                ->name('product.index');
        });
        Route::prefix('product')->group(function () {
            Route::post('/', ProductStoreController::class)
                ->name('product.store');
            Route::prefix('{id}')->group(function () {
                Route::put('/', ProductUpdateController::class)
                    ->name('product.update');
                Route::get('/', ProductShowController::class)
                    ->name('product.show');
                Route::delete('/', ProductDeleteController::class)
                    ->name('product.delete');
                Route::patch('/restore', ProductRestoreController::class)
                    ->name('product.restore');
            });
        });

        /**
         * Breeds
         */
        Route::prefix('breeds')->group(function () {
            Route::get('/', BreedListController::class)
                ->name('breeds.index');
        });

        /**
         * Users
         */
        Route::prefix('users')->group(function () {
            Route::get('', UsersOfAccountController::class)
                ->name('account.index');
            Route::post('', UserCreateController::class)
                ->name('account.user.create');
            Route::prefix('{id}')->group(function () {
                Route::delete('change-status', ChangeUserStatusController::class)
                    ->name('account.change-status');
            });
        });
    });
});
