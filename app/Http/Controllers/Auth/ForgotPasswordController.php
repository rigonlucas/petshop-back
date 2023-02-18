<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Application\Auth\ForgotPasswordAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Auth\ForgotPasswordRequest;
use Illuminate\Http\JsonResponse;

class ForgotPasswordController extends Controller
{
    public function __invoke(
        ForgotPasswordRequest $request,
        ForgotPasswordAction $service
    ): JsonResponse {
        $service->newPassword($request->validated('email'));
        return response()->json();
    }
}
