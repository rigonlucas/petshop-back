<?php

namespace App\Services\Application\Accounts\DTO;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class UserCreateData extends DataTransferObject
{
    public string $name;
    public string $email;
    public ?int $account_id;
    public ?string $password;

    public static function fromRequest(Request $request): self
    {
        return new self($request->validated());
    }
}