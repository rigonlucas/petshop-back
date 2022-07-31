<?php

namespace App\Rules\Pet;

use App\Models\Clients\Pet;
use Illuminate\Contracts\Validation\Rule;

class PetBelongsToClientRule implements Rule
{
    public function __construct(private readonly int $clientId)
    {
        //
    }
    public function passes($attribute, $value)
    {
        return Pet::query()
            ->where('id', '=', $value)
            ->where('client_id', '=', $this->clientId)
            ->exists();
    }

    public function message()
    {
        return 'Este pet não pertence ao cliente selecionado';
    }
}
