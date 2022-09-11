<?php

namespace App\Services\Application\Schedules\DTO;

use Illuminate\Foundation\Http\FormRequest;
use Spatie\DataTransferObject\DataTransferObject;

class ScheduleProductData extends DataTransferObject
{
    public int $product_id;
    public int $quantity;
    public float $price;
    public ?float $discount = 0;
}