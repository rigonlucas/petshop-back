<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Application\Auth\VerifyService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class VerifyEmailController extends Controller
{
    public function __invoke(Request $request, string $hash, VerifyService $service): Redirector|RedirectResponse|Application
    {
        $emailVerified = $service->register($hash);
        if ($emailVerified) {
            return redirect(config('app.url_front'));
        }
        return abort(404);
    }
}
