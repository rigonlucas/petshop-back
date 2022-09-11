<?php

namespace App\Rules\Schedule\Product;

use App\Models\Schedules\ScheduleHasProduct;
use Illuminate\Contracts\Validation\Rule;

class ScheduleHasProductDeleteRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(private readonly int $scheduleProductId)
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return ScheduleHasProduct::query()
            ->where('id', '=', $this->scheduleProductId)
            ->where('schedule_id', '=', $value)
            ->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'O produto não foi encontrado no agendamento';
    }
}
