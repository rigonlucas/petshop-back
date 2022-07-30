<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Services\Application\Accounts\AccountUsersListService;
use App\Services\Application\Accounts\DTO\AccountUserListData;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AccountController extends Controller
{
    public function indexUsers(Request $request, AccountUsersListService $service): AnonymousResourceCollection
    {
        $data = AccountUserListData::fromRequest($request);

        $accountUsers = $service
            ->list($data, $request->user()->account_id);
        return UserResource::collection($accountUsers);
    }
}
