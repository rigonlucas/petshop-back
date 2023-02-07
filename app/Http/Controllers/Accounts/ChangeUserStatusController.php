<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Services\Application\Accounts\ChangeStatusUsersService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ChangeUserStatusController extends Controller
{
    /**
     * @param Request $request
     * @param int $id
     * @param ChangeStatusUsersService $service
     * @return Response
     */
    public function __invoke(Request $request, int $id, ChangeStatusUsersService $service): Response
    {
        $userToChange = $service->findUser($id);
        $service->change($userToChange);
        return response()->noContent();
    }
}
