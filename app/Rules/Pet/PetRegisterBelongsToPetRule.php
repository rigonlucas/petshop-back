<?php

namespace App\Rules\Pet;

use App\Models\Clients\PetRegisters;
use Illuminate\Contracts\Validation\Rule;

class PetRegisterBelongsToPetRule implements Rule
{
    public function __construct(private readonly int $petId)
    {
        //
    }

    public function passes($attribute, $value)
    {
        return PetRegisters::query()
            ->where('id', '=', $value)
            ->where('pet_id', '=', $this->petId)
            ->exists();
    }

    public function message()
    {
        return 'Registro não encontrado';
    }
}
