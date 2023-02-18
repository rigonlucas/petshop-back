<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Application\Auth\LogoutAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LogoutController extends Controller
{

    public function __invoke(Request $request, LogoutAction $logout): JsonResponse
    {
        $logout->logout($request->user());
        return response()->json();
    }

}