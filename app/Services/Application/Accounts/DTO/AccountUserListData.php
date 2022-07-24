<?php

namespace App\Services\Application\Accounts\DTO;

use App\Services\PaginatedDataTransferObject;
use Illuminate\Http\Request;

class AccountUserListData extends PaginatedDataTransferObject
{
    public ?string $name = null;

    public static function fromRequest(Request $request): self
    {
        return new self($request->query());
    }
}