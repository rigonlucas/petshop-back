<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Application\Accounts\ChangeStatusUsersService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Gate;

class ChangeUserStatusController extends Controller
{
    public function __invoke(Request $request, int $id, ChangeStatusUsersService $service): \Illuminate\Http\Response
    {
        Gate::authorize('userAdmin', $request->user());
        $userToChange = $service->findUser($id);
        $service->change($userToChange);
        return response()->noContent();
    }
}
