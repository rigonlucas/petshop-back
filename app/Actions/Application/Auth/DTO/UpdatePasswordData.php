<?php

namespace App\Actions\Application\Auth\DTO;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class UpdatePasswordData extends DataTransferObject
{
    public string $email;
    public string $password;
    public ?string $password_confirmation = null;

    public static function fromRequest(Request $request): self
    {
        return new self($request->validated());
    }
}