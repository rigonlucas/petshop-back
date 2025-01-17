<?php

namespace App\Actions\Application\Products\DTO;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class ProductRestoreData extends DataTransferObject
{
    public ?int $id;
    public ?int $account_id;

    public static function fromRequest(Request $request): self
    {
        return new self($request->validated());
    }
}