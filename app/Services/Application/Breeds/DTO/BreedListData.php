<?php

namespace App\Services\Application\Breeds\DTO;

use App\Services\PaginatedDataTransferObject;
use Illuminate\Http\Request;

class BreedListData extends PaginatedDataTransferObject
{
    public ?string $type = null;

    public static function fromRequest(Request $request): self
    {
        return new self($request->query());
    }
}