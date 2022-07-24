<?php

namespace App\Services\Application\Clients\DTO;

use App\Services\PaginatedDataTransferObject;
use Illuminate\Http\Request;

class ClientListData extends PaginatedDataTransferObject
{
    public ?string $period_date = null;
    public ?string $name = null;

    public static function fromRequest(Request $request): self
    {
        return new self($request->query());
    }
}