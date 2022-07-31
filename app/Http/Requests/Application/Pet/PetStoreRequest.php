<?php

namespace App\Http\Requests\Application\Pet;

use App\Enums\BreedsEnum;
use App\Enums\ProductsEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class PetStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:500'],
            'client_id' => ['required', 'int', 'min:1'],
            'breed_id' => ['required', 'numeric', 'gt:0', 'min:1'],
            'birthday' => ['required', 'date_format:Y-m-d', 'before:today'],
        ];
    }
}
