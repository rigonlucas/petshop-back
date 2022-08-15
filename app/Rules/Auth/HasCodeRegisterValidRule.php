<?php

namespace App\Rules\Auth;

use App\Models\Users\TrialCode;
use Illuminate\Contracts\Validation\Rule;

class HasCodeRegisterValidRule implements Rule
{
    public function __construct()
    {
    }

    public function passes($attribute, $value)
    {
        return TrialCode::query()
            ->where('code', '=', $value)
            ->exists();
    }

    public function message()
    {
        return 'Código de registro inválido ou inexistente';
    }
}