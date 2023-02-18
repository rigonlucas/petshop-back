<?php

namespace App\Actions\Application\Products\DTO;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class ProductDeleteData extends DataTransferObject
{
    public ?int $id;
    public ?int $account_id;

    public static function fromRequest(Request $request): self
    {
        return new self($request->query());
    }
}