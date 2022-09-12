<?php

namespace App\Services\Application\Clients\DTO;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class ClientStoreData extends DataTransferObject
{
    public ?int $account_id = null;
    public string $name;
    public ?string $email;
    public ?string $phone;

    public static function fromRequest(Request $request): self
    {
        return new self($request->validated());
    }
}