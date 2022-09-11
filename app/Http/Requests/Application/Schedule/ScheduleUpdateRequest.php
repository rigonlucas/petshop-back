<?php

namespace App\Http\Requests\Application\Schedule;

use App\Enums\SchedulesStatusEnum;
use App\Enums\SchedulesTypesEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class ScheduleUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "client_id" => ['sometimes', 'required', 'int', 'min:1'],
            "pet_id" => ['sometimes', 'required', 'int', 'min:1'],
            "type" => ['sometimes', 'required', 'int', 'min:1', new Enum(SchedulesTypesEnum::class)],
            "status" => ['sometimes', 'required', 'int', 'min:1', new Enum(SchedulesStatusEnum::class)],
            "user_id" => ['sometimes', 'nullable', 'int', 'min:1'],
            "start_at" => ['sometimes', 'required', 'date_format:Y-m-d H:i:s'],
            "duration" => ['sometimes', 'required', 'min:1'],
            "description" => ['sometimes', 'nullable', 'string', 'min:1', 'max:500'],
        ];
    }
}
