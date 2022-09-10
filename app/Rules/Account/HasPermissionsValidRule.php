<?php

namespace App\Rules\Account;

use Illuminate\Contracts\Validation\Rule;
use Spatie\Permission\Models\Permission;

class HasPermissionsValidRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Permission::query()->whereIn('name', $value)->count() === count($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Uma ou mais permissões não foram encontradas';
    }
}
