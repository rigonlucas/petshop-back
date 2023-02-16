<?php

use App\Http\Middleware\OnlyInLocalHost;
use App\Jobs\Batches\Tests\ExecuteFinishJob;
use App\Jobs\Batches\Tests\ExecuteOneJob;
use App\Jobs\Batches\Tests\ExecuteTwoJob;
use App\Models\Mongodb\BackgroundJobs;
use App\Models\User;
use App\Notifications\Auth\ForgotPasswordNotify;
use Illuminate\Mail\Markdown;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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

        Route::get('mongo', function () {
            //BackgroundJobs::query()->create(['AAAA' => 'teste']);

            BackgroundJobs::query()->delete();
            dd(
                BackgroundJobs::query()->count(),
                BackgroundJobs::query()
                    ->where('uuid', '=', 'b47dbc98-0986-4c3c-b567-c6b64c686e05')
                    ->first()
                    ?->toArray()
            );
        });

        Route::get('jobs-batch', function () {
            $uuid = Str::uuid();
            $jobs = [
                new ExecuteOneJob($uuid),
                new ExecuteTwoJob($uuid),
                new ExecuteFinishJob($uuid)
            ];
            Bus::batch($jobs)->dispatch();
        });
    });