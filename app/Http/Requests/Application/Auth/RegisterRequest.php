<?php

namespace App\Http\Requests\Application\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'min:5', 'max:100'],
            'email' => ['required', 'email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'company_name' => ['required', 'string', 'min:10', 'max:100'],
            'password' => ['required',  'confirmed', Password::min(8)]
        ];
    }
}
