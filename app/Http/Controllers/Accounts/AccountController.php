<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Services\App\Accounts\AccountUsersListService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AccountController extends Controller
{
    public function indexUsers(Request $request, AccountUsersListService $service): AnonymousResourceCollection
    {
        $includes = $request->query('include', '');
        $perPage = $request->query('per_page', 10);
        $name = $request->query('name');
        $accountUsers = $service
            ->setRequestedIncludes(explode(',', $includes))
            ->accountUsers()
            ->filterByName($name)
            ->getQuery()
            ->paginate($perPage);
        return UserResource::collection($accountUsers);
    }
}
