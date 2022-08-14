<?php

namespace App\Services\Application\Products\DTO;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class ProductUpdateData extends DataTransferObject
{
    public ?int $id;
    public string $name;
    public string $description;
    public int $type;
    public float $cost;
    public float $price;
    public ?int $account_id = null;
    public ?string $validate = null;
    public ?int $measurement_unit = null;

    public static function fromRequest(Request $request): self
    {
        return new self($request->validated());
    }
}