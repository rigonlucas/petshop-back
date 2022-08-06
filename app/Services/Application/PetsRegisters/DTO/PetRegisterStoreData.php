<?php

namespace App\Services\Application\PetsRegisters\DTO;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class PetRegisterStoreData extends DataTransferObject
{
    public string $type;
    public string $register;
    public ?int $pet_id;
    public ?int $account_id;

    public static function fromRequest(Request $request): self
    {
        return new self($request->validated());
    }
}