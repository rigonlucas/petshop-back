<?php

namespace App\Services\Application\Accounts;

use App\Models\User;
use App\Models\Users\Account;
use App\Notifications\Auth\AccountUserRegisterNotify;
use App\Rules\Account\HasPermissionsValidRule;
use App\Rules\AccountHasEntityRule;
use App\Rules\Auth\Account\UserCanCreateUserRule;
use App\Rules\UsersCanNotBeSameRule;
use App\Services\Application\Accounts\DTO\UserCreateData;
use App\Services\Application\Accounts\DTO\UserPermissionData;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserPermissionService extends BaseService
{
    public function sync(UserPermissionData $data, User $user): void
    {
        $this->validate($data, $user);
        DB::transaction(function () use ($data) {
            /** @var User $user */
            $user = User::query()->findOrFail($data->user_id);
            if (!$data->is_admin) {
                $user->removeRole('User Admin');
                $user->syncPermissions($data->permissions);
            } else {
                $user->assignRole('User Admin');
            }
        });
    }

    private function validate(UserPermissionData $data, User $user): void
    {
        Validator::make(
            $data->toArray(),
            [
                'account_id' => [
                    'required',
                    'integer',
                ],
                'user_id' => [
                    'required',
                    'integer',
                    new AccountHasEntityRule(User::class, $data->account_id),
                    new UsersCanNotBeSameRule($user->id)
                ],
                'is_admin' => [
                    'required',
                    'boolean',
                ],
                'permissions' => [
                    'required',
                    'array',
                    new HasPermissionsValidRule()
                ]
            ]
        )->validate();
    }
}