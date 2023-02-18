<?php

namespace App\Actions\Application\Vaccines\DTO;

use App\Actions\PaginatedDataTransferObject;
use Illuminate\Http\Request;

class VaccinesListData extends PaginatedDataTransferObject
{
    public ?string $name = null;

    public static function fromRequest(Request $request): self
    {
        return new self($request->query());
    }
}