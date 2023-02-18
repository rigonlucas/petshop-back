<?php

namespace App\Http\Controllers\Accounts;

use App\Actions\Application\Accounts\ChangeStatusUsersAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ChangeUserStatusController extends Controller
{
    /**
     * @param Request $request
     * @param int $id
     * @param ChangeStatusUsersAction $service
     * @return Response
     */
    public function __invoke(Request $request, int $id, ChangeStatusUsersAction $service): Response
    {
        $userToChange = $service->findUser($id);
        $service->change($userToChange);
        return response()->noContent();
    }
}
