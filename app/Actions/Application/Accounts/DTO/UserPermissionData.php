<?php

namespace App\Actions\Application\Accounts\DTO;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class UserPermissionData extends DataTransferObject
{
    public ?bool $is_admin;
    public array $permissions;
    public int $user_id;
    public ?int $account_id = null;

    public static function fromRequest(Request $request): self
    {
        return new self($request->validated());
    }
}