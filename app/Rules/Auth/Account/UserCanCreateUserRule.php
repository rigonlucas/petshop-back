<?php

namespace App\Rules\Auth\Account;

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
        return Account::query()
            ->where('id', '=', $this->accountId)
            ->where('user_id', '=', $value)
            ->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Apenas o dono da conta pode criar novos usuários';
    }
}
