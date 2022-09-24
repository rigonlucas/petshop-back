<?php

namespace App\Rules\Vaccine;

use Illuminate\Contracts\Validation\Rule;

class IsAllVaccinesDifferentsRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(private readonly array $targetVaccines)
    {
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return array_count_values($this->targetVaccines)[$value] == 1;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'As vacinas não podem ser iguais';
    }
}
