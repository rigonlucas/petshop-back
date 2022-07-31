<?php

namespace App\Services\Application\Pets\DTO;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class PetStoreData extends DataTransferObject
{
    public string $name;
    public string $birthday;
    public int $breed_id;
    public int $client_id;
    public ?int $account_id = null;

    public static function fromRequest(Request $request): self
    {
        return new self($request->validated());
    }
}