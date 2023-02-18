<?php

namespace App\Actions\Application\Accounts;

use App\Actions\Application\Accounts\DTO\UserPermissionData;
use App\Actions\BaseAction;
use App\Models\User;
use App\Rules\Account\HasPermissionsValidRule;
use App\Rules\AccountHasEntityRule;
use App\Rules\UsersCanNotBeSameRule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserPermissionAction extends BaseAction
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