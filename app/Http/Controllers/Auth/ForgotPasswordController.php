<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Auth\ForgotPasswordRequest;
use App\Services\Application\Auth\ForgotPasswordService;

class ForgotPasswordController extends Controller
{
    public function __invoke(ForgotPasswordRequest $request, ForgotPasswordService $service)
    {
        $service->newPassword($request->validated('email'));
        return response()->json();
    }
}