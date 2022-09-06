<?php

namespace App\Services\Application\Accounts;

use App\Models\User;
use App\Models\Users\Account;
use App\Notifications\Auth\AccountUserRegisterNotify;
use App\Rules\Auth\Account\UserCanCreateUserRule;
use App\Services\Application\Accounts\DTO\UserCreateData;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserCreateService extends BaseService
{
    public function create(UserCreateData $data, Mixed $user): Model|Builder
    {
        $data->account_id = $user->account_id;
        $this->validate($data, $user);
        $tempPassword = Str::random(6);
        $data->password = Hash::make($tempPassword);
        $user = User::query()->create($data->toArray());
        Notification::route('mail', $user->email)->notify(new AccountUserRegisterNotify($user, $tempPassword));
        return $user;
    }

    private function validate(UserCreateData $data, mixed $user)
    {
        $account = Account::query()->withCount('users')->find($data->account_id);
        Validator::make(
            [
                ...$data->toArray(),
                ...[
                    'current_user_id' => $user->id,
                    'account_users_count' => $account->users_count,
                ]
            ],
            [
                'name' => ['required', 'string', 'min:5', 'max:100'],
                'email' => ['required', 'email', 'unique:users,email'],
                'current_user_id' => ['required', new UserCanCreateUserRule($data->account_id)],
                'account_users_count' => ['required', 'lt:' . $account->account_users]
            ]
        )->validate();
    }
}