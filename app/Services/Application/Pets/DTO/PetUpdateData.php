<?php

namespace App\Services\Application\Pets\DTO;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class PetUpdateData extends DataTransferObject
{
    public ?int $id;
    public string $name;
    public ?string $birthday = null;
    public int $breed_id;
    public int $client_id;
    public ?int $account_id = null;

    public static function fromRequest(Request $request): self
    {
        return new self($request->validated());
    }
}