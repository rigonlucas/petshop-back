<?php

namespace App\Actions\Application\Breeds\DTO;

use App\Actions\PaginatedDataTransferObject;
use Illuminate\Http\Request;

class BreedListData extends PaginatedDataTransferObject
{
    public ?string $type = null;

    public static function fromRequest(Request $request): self
    {
        return new self($request->query());
    }
}