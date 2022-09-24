<?php

namespace App\Http\Requests\Application\Pet\Vaccine;

use Illuminate\Foundation\Http\FormRequest;

class PetVaccineStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'pet_id' => ['required', 'int', 'min:1',],
            'vaccine_id' => ['required', 'numeric', 'gt:0', 'min:1',],
            'applied' => ['required', 'boolean'],
            'applied_at' => ['nullable', 'date_format:d/m/Y', 'before_or_equal:today']
        ];
    }
}
