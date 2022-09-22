<?php

use App\Http\Controllers\Accounts\ChangeUserStatusController;
use App\Http\Controllers\Accounts\UserCreateController;
use App\Http\Controllers\Accounts\UserPermissionsController;
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
use App\Http\Controllers\Permissions\PermissionsShowController;
use App\Http\Controllers\Pet\PetDeleteController;
use App\Http\Controllers\Pet\PetListController;
use App\Http\Controllers\Pet\PetShowController;
use App\Http\Controllers\Pet\PetStoreController;
use App\Http\Controllers\Pet\PetUpdateController;
use App\Http\Controllers\Products\Export\ProductsExportController;
use App\Http\Controllers\Products\Product\ProductDeleteController;
use App\Http\Controllers\Products\Product\ProductListController;
use App\Http\Controllers\Products\Product\ProductRestoreController;
use App\Http\Controllers\Products\Product\ProductShowController;
use App\Http\Controllers\Products\Product\ProductStoreController;
use App\Http\Controllers\Products\Product\ProductUpdateController;
use App\Http\Controllers\Schedules\Exports\SchedulesExportController;
use App\Http\Controllers\Schedules\History\ScheduleHistoryDeleteController;
use App\Http\Controllers\Schedules\History\ScheduleHistoryIndexController;
use App\Http\Controllers\Schedules\History\ScheduleHistoryStoreController;
use App\Http\Controllers\Schedules\Products\ScheduleProductsDeleteController;
use App\Http\Controllers\Schedules\Products\ScheduleProductsStoreController;
use App\Http\Controllers\Schedules\Schedule\AvailableProfessionalsController;
use App\Http\Controllers\Schedules\Schedule\ScheduleDeleteController;
use App\Http\Controllers\Schedules\Schedule\ScheduleListController;
use App\Http\Controllers\Schedules\Schedule\ScheduleShowController;
use App\Http\Controllers\Schedules\Schedule\ScheduleStoreController;
use App\Http\Controllers\Schedules\Schedule\ScheduleUpdateController;
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
            Route::prefix('export')->group(function () {
                Route::get('{status}', SchedulesExportController::class);
            });
            Route::get('professionals/available', AvailableProfessionalsController::class)
                ->name('schedules.available.professionals');
            Route::post('/', ScheduleStoreController::class)
                ->name('schedules.store');
            Route::prefix('{id}')->group(function () {
                Route::get('/', ScheduleShowController::class)
                    ->name('schedules.get');
                Route::put('/', ScheduleUpdateController::class)
                    ->name('schedules.update');
                Route::delete('/', ScheduleDeleteController::class)
                    ->name('schedules.delete');
                Route::prefix('status')->group(function () {
                    Route::patch('scheduled', SchedulesOpenController::class)
                        ->name('schedules.status.open');
                    Route::patch('executing', SchedulesExecutingController::class)
                        ->name('schedules.status.executing');
                    Route::patch('archived', SchedulesArchivedController::class)
                        ->name('schedules.status.archived');
                    Route::patch('canceled', SchedulesCanceledController::class)
                        ->name('schedules.status.canceled');
                    Route::patch('finished', SchedulesFinishedController::class)
                        ->name('schedules.status.finished');
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
                ->name('clients.index');
            Route::post('/', ClientStoreController::class)
                ->name('clients.store');
            Route::prefix('{id}')->group(function () {
                Route::get('/', ClientShowController::class)
                    ->name('clients.show');
                Route::put('/', ClientUpdateController::class)
                    ->name('clients.update');
                Route::delete('/', ClientDeleteController::class)
                    ->name('clients.delete');//necessário validar os pets
            });
        });

        /**
         * Pets
         */
        Route::prefix('pets')->group(function () {
            Route::get('/', PetListController::class)
                ->name('pets.index');
            Route::post('/', PetStoreController::class)
                ->name('pets.store');
            Route::prefix('/{id}')->group(function () {
                Route::get('/', PetShowController::class)
                    ->name('pets.show');
                Route::put('/', PetUpdateController::class)
                    ->name('pets.update');
                Route::delete('/', PetDeleteController::class)
                    ->name('pets.delete');
            });
        });

        /**
         * Products
         */
        Route::prefix('products')->group(function () {
            Route::get('/', ProductListController::class)
                ->name('product.index');
            Route::get('export', ProductsExportController::class)
                ->name('product.export');

            Route::post('/', ProductStoreController::class)
                ->name('products.store');
            Route::prefix('{id}')->group(function () {
                Route::put('/', ProductUpdateController::class)
                    ->name('products.update');
                Route::get('/', ProductShowController::class)
                    ->name('products.show');
                Route::delete('/', ProductDeleteController::class)
                    ->name('products.delete');
                Route::patch('/restore', ProductRestoreController::class)
                    ->name('products.restore');
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
                Route::prefix('permissions')->group(function () {
                    Route::put('', UserPermissionsController::class)
                        ->name('account.permission.sync');
                });
            });
        });

        /**
         * Permissions
         */
        Route::prefix('permissions')->group(function () {
            Route::get('', PermissionsShowController::class)
                ->name('permissions.index');
        });
    });
});
