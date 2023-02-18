<?php

namespace App\Actions\Application\Clients\DTO;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class ClientUpdateData extends DataTransferObject
{
    public ?int $id = null;
    public ?int $account_id = null;
    public string $name;
    public string $email;
    public string $phone;

    public static function fromRequest(Request $request): self
    {
        return new self($request->validated());
    }
}