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
            "client_id" => ['required', 'int', 'min:1'],
            "pet_id" => ['required', 'int', 'min:1'],
            "type" => ['required', 'int', 'min:1', new Enum(SchedulesTypesEnum::class)],
            "status" => ['required', 'int', 'min:1', new Enum(SchedulesStatusEnum::class)],
            "user_id" => ['required', 'int', 'min:1'],
            "start_at" => ['required', 'date_format:Y-m-d H:i:s'],
            "duration" => ['required', 'min:1'],
            "description" => ['nullable', 'string', 'min:1', 'max:500'],
        ];
    }
}
