<?php

namespace App\Rules\ScheduleProducts;

use App\Models\Schedules\ScheduleHasProduct;
use Illuminate\Contracts\Validation\Rule;

class ScheduleHasProductIdRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(private readonly int $productId)
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
            ->where('product_id', '=', $this->productId)
            ->where('schedule_id', '=', $value)
            ->doesntExist();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'O produto já está relacionado ao agendamento';
    }
}
