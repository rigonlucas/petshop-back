<?php

namespace App\Http\Requests\Application\Schedule\Status;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleFinishedRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'reschedule_date' => ['nullable', 'date']
        ];
    }
}
