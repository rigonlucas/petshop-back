<?php

namespace App\Rules\Auth\Account;

use App\Models\User;
use App\Models\Users\Account;
use Illuminate\Contracts\Validation\Rule;

class UserCanCreateUserRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(private readonly int $accountId)
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        /** @var User $user */
        $user = User::query()
            ->where('account_id', '=', $this->accountId)
            ->where('id', '=', $value)
            ->firstOrFail();
         return $user->hasRole('User Admin') || $user->hasPermissionTo('user_management_access');
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Apenas administradores podem criar novas contas';
    }
}
