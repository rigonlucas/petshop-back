<?php

namespace App\Services\Application\Schedules\Schedule\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class ScheduleProductData extends DataTransferObject
{
    public int $product_id;
    public int $quantity;
    public float $price;
    public ?float $discount = 0;
}