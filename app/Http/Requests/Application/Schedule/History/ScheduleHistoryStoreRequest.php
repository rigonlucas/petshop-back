<?php

namespace App\Http\Requests\Application\Schedule\History;

use App\Enums\PetRegisterTypesEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class ScheduleHistoryStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'register' => ['required', 'string', 'min:3', 'max:500'],
            'type' => ['required', 'int', 'min:1', new Enum(PetRegisterTypesEnum::class)],
        ];
    }
}
