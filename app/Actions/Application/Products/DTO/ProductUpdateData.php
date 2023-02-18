<?php

namespace App\Actions\Application\Products\DTO;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class ProductUpdateData extends DataTransferObject
{
    public ?int $id;
    public string $name;
    public ?string $description = null;
    public int $type;
    public float $cost;
    public float $price;
    public ?int $account_id = null;
    public ?string $validate = null;

    public static function fromRequest(Request $request): self
    {
        return new self($request->validated());
    }
}