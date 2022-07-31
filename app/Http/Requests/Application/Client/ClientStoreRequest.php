<?php

namespace App\Http\Requests\Application\Client;

use Illuminate\Foundation\Http\FormRequest;

class ClientStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'min:1', 'max:500'],
            'email' => ['nullable', 'email'],
            'phone' => ['nullable', 'string', 'max:100'],
        ];
    }
}
