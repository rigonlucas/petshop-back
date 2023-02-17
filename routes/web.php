<?php

use App\Http\Controllers\Downloads\FilesDownloadController;
use App\Http\Controllers\Jobs\Tests\JobTestController;
use App\Http\Middleware\OnlyInLocalHost;
use App\Models\Mongodb\ExportsJob;
use App\Models\User;
use App\Notifications\Auth\ForgotPasswordNotify;
use Illuminate\Mail\Markdown;
use Illuminate\Support\Facades\Route;
use MongoDB\BSON\UTCDateTime;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('files/download/', FilesDownloadController::class)->name('files.download');


Route::middleware(OnlyInLocalHost::class)
    ->prefix('local')
    ->group(callback: function () {
        Route::get('/', function () {
            return view('welcome');
        });

        Route::get('test-email', function () {
            $message = (new ForgotPasswordNotify(User::query()->first(), 'aaaaa'))
                ->toMail('example@gmail.com');
            $markdown = new Markdown(view(), config('mail.markdown'));

            return $markdown->render('vendor.notifications.email', $message->data());
        });

        Route::get('mongo-delete', function () {
            ExportsJob::query()->delete();
            dd(
                ExportsJob::query()->count(),
                ExportsJob::query()
                    ->where('uuid', '=', 'b47dbc98-0986-4c3c-b567-c6b64c686e05')
                    ->first()
                    ?->toArray()
            );
        });


        Route::get('mongo-test', function () {
            dd(
                new UTCDateTime(now()),
                ExportsJob::query()->first(),
            );
            ExportsJob::query()->create(['AAAA' => 'teste']);

            dd(
                ExportsJob::query()->count(),
                ExportsJob::query()
                    ->where('uuid', '=', 'b47dbc98-0986-4c3c-b567-c6b64c686e05')
                    ->first()
                    ?->toArray()
            );
        });

        Route::get('jobs-batch', [JobTestController::class, 'test_batches']);
    });