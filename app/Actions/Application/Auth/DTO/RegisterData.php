<?php

namespace App\Actions\Application\Auth\DTO;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class RegisterData extends DataTransferObject
{
    public string $name;
    public string $email;
    public ?string $phone;
    public ?string $company_name;
    public string $password;
    public ?Carbon $expire_at = null;
    public ?int $account_id = null;
    public ?string $email_verificarion_hash = null;
    public ?string $code = null;

    public static function fromRequest(Request $request): self
    {
        return new self($request->validated());
    }
}