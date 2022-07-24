<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Clients\BreedController;
use App\Http\Controllers\Clients\ClientController;
use App\Http\Controllers\Products\ProductController;
use App\Http\Controllers\Schedules\ScheduleController;
use Illuminate\Http\Request;
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
            Route::get('/', [ScheduleController::class, 'index']);
        });

        /**
         * Clients
         */
        Route::prefix('clients')->group(function () {
            Route::get('/', [ClientController::class, 'index']);
        });
        Route::prefix('client')->group(function (){
            Route::prefix('{clientId}')->group(function () {
                Route::get('/', [ClientController::class, 'show'])
                    ->where('clientId', '[0-9]+');
            });
        });

        /**
         * Products
         */
        Route::prefix('products')->group(function () {
            Route::get('/', [ProductController::class, 'index']);
        });

        /**
         * Breeds
         */
        Route::prefix('breeds')->group(function () {
            Route::get('/', [BreedController::class, 'index']);

        });

    });
});
