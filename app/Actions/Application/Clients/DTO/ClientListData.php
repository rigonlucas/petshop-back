<?php

namespace App\Actions\Application\Clients\DTO;

use App\Actions\PaginatedDataTransferObject;
use Illuminate\Http\Request;

class ClientListData extends PaginatedDataTransferObject
{
    public ?string $name = null;

    public static function fromRequest(Request $request): self
    {
        return new self($request->query());
    }
}