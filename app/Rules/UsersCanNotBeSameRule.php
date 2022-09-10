<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class UsersCanNotBeSameRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(private readonly int $userId)
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
        return $value !== $this->userId;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Você não pode mudar sua própria permissão';
    }
}
