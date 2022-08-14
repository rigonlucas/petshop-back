<?php

namespace App\Rules\Auth;

use Illuminate\Contracts\Validation\Rule;

class CheckPasswordResetRule implements Rule
{
    public function __construct()
    {
    }

    public function passes($attribute, $value)
    {
        return $value;
    }

    public function message()
    {
        return 'Dados não encontrados';
    }
}