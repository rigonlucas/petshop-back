<?php

use App\Http\Middleware\OnlyInLocalHost;
use App\Models\User;
use App\Notifications\UserRegisterNotify;
use Illuminate\Mail\Markdown;
use Illuminate\Support\Facades\Route;

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
    ->group(function (){
        Route::get('test-email', function () {
            $message = (new UserRegisterNotify(User::query()->find(3)))
                ->toMail('example@gmail.com');
            $markdown = new Markdown(view(), config('mail.markdown'));

            return $markdown->render('vendor.notifications.email', $message->data());
        });
    });