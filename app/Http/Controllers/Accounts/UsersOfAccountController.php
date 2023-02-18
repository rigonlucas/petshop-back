<?php

namespace App\Http\Controllers\Accounts;

use App\Actions\Application\Accounts\AccountUsersListAction;
use App\Actions\Application\Accounts\DTO\AccountUserListData;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UsersOfAccountController extends Controller
{
    /**
     * @param Request $request
     * @param AccountUsersListAction $service
     * @return AnonymousResourceCollection
     */
    public function __invoke(Request $request, AccountUsersListAction $service): AnonymousResourceCollection
    {
        $data = AccountUserListData::fromRequest($request);
        $accountUsers = $service->list($data, $request->user()->account_id);
        return UserResource::collection($accountUsers);
    }
}
