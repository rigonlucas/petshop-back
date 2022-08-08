<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Application\Auth\LogoutService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LogoutController extends Controller
{

    public function __invoke(Request $request, LogoutService $logout): JsonResponse
    {
        $logout->logout($request->user());
        return response()->json();
    }

}