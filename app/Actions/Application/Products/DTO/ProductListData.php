<?php

namespace App\Actions\Application\Products\DTO;

use App\Actions\PaginatedDataTransferObject;
use Illuminate\Http\Request;

class ProductListData extends PaginatedDataTransferObject
{
    public ?string $period_date = null;
    public ?string $name = null;

    public static function fromRequest(Request $request): self
    {
        return new self($request->query());
    }
}