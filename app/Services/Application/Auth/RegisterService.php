<?php

namespace App\Services\Application\Auth;

use App\Models\User;
use App\Models\Users\Account;
use App\Notifications\Auth\UserRegisterNotify;
use App\Rules\Auth\HasCodeRegisterValidRule;
use App\Services\Application\Auth\DTO\RegisterData;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class RegisterService extends BaseService
{
    public function register(RegisterData $data): User|Model
    {
        $this->validate($data);
        $this->setTrialAccount($data);
        $this->createAccount($data);
        $data->password = Hash::make($data->password);
        $data->email_verificarion_hash = sha1($data->email);
        /** @var User $user */
        $user = User::query()->create($data->toArray());
        $user->assignRole('User Admin');
        Notification::route('mail' , $user->email)->notify(new UserRegisterNotify($user));
        return $user;
    }

    private function validate(RegisterData $data)
    {
        Validator::make(
            $data->toArray(),
            [
                'name' => ['required', 'string', 'min:5', 'max:100'],
                'email' => ['required', 'email', 'unique:users,email'],
                'phone' => ['nullable', 'string', 'max:20'],
                'company_name' => ['required', 'string', 'min:10', 'max:100'],
                'code' => ['required', 'string', 'max:8', 'min:8', new HasCodeRegisterValidRule()],
            ]
        )->validate();
        $data->name = ucwords($data->name);
    }

    private function setTrialAccount(RegisterData $data)
    {
        $data->expire_at = now()->addDays(config('app.trial_days'));
    }

    private function createAccount(RegisterData $data): void
    {
        $account = Account::query()->create([
            'name' => ucwords($data->company_name),
            'expire_at' => $data->expire_at
        ]);
        $data->account_id = $account->id;
        $data->company_name = null;
    }
}