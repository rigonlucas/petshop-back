<?php

namespace App\Services\Application\Products\DTO;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class ProductStoreData extends DataTransferObject
{
    public string $name;
    public string $description;
    public int $type;
    public float $cost_price;
    public float $price;
    public ?int $account_id = null;
    public ?string $validate = null;

    public static function fromRequest(Request $request): self
    {
        return new self($request->validated());
    }
}