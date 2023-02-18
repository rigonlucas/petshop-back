<?php

namespace App\Actions\Application\Schedules\Products\DTO;

use App\Http\Requests\Application\Schedule\Products\ScheduleProductsStoreRequest;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class ScheduleProductsStoreData extends DataTransferObject
{
    public ?int $schedule_id = null;
    public ?int $account_id = null;
    public ?int $product_id = null;
    public ?float $price = null;
    public ?float $discount = null;
    public ?int $quantity = null;

    /**
     * @throws UnknownProperties
     */
    public static function fromRequest(ScheduleProductsStoreRequest $request): self
    {
        return new self($request->validated());
    }
}