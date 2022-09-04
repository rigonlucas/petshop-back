<?php

namespace App\Services\Application\ScheduleProducts\DTO;

use App\Http\Requests\Application\ScheduleProducts\ScheduleProductsStoreRequest;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class ScheduleProductsStoreData extends DataTransferObject
{
    public array $products;
    public ?int $schedule_id = null;
    public ?int $account_id = null;

    /**
     * @throws UnknownProperties
     */
    public static function fromRequest(ScheduleProductsStoreRequest $request): self
    {
        return new self($request->validated());
    }
}