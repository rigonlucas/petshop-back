<?php

namespace App\Actions\Application\Pets\DTO;

use App\Actions\PaginatedDataTransferObject;
use Illuminate\Http\Request;

class PetListData extends PaginatedDataTransferObject
{
    public ?string $name = null;
    public ?int $client_id = null;

    public static function fromRequest(Request $request): self
    {
        return new self($request->query());
    }
}